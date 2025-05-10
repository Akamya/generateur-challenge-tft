<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Classe;
use App\Models\Constraint;
use App\Models\Origin;
use App\Models\Position;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

function formatRound(int $last_round): string {
    if ($last_round < 5) {
        $stage = 1;
        $round_number = $last_round;
    } else {
        $stage = intdiv($last_round - 5, 7) + 2;
        $round_number = ($last_round - 5) % 7 + 1;
    }

    return "{$stage}-{$round_number}";
}

function getActiveChallenge($user){
    if ($user) {
        $latestChallenge = Challenge::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        return $latestChallenge;
    }
}

function getPuuidFromRiotId($riotUsername)
{
    $apiKey = env('RIOT_API_KEY');

    $response = Http::get("https://europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$riotUsername}/EUW?api_key={$apiKey}");
    if ($response->failed()) {
        return null;
    }
    $puuid = $response->json()['puuid'];
    return $puuid;
}

function getLastMatch($puuid)
{
    $apiKey = env('RIOT_API_KEY');
    $matchesResponse = Http::get("https://europe.api.riotgames.com/tft/match/v1/matches/by-puuid/{$puuid}/ids?api_key={$apiKey}");
    if ($matchesResponse->failed()) {
        return null;
    }
    $matchIDs = $matchesResponse->json();
    if(!$matchIDs){
        return null;
    }
    $matchID = $matchIDs[0];
    $matchResponse = Http::get("https://europe.api.riotgames.com/tft/match/v1/matches/{$matchID}?api_key={$apiKey}");
    if ($matchResponse->failed()) {
        return null;
    }
    $match = $matchResponse->json();
    $matchInfo = collect($match["info"]["participants"])->firstWhere('puuid', $puuid);

    return ['matchInfo'=>$matchInfo, 'matchID'=>$matchID];
}

function verifyPosition($requiredPosition, $position)
{
    $success = $position <= $requiredPosition->value;
    $info = "You reached position ".$position;
    return ["success"=>$success, "info"=>$info];
}

function verifyTrait($requiredTrait, $traits, $level)
{
    $technicalName = $requiredTrait->technical_name;
    $foundTrait = collect($traits)->firstWhere('name', $technicalName);
    if(!$foundTrait){
        return ["success"=>false, "info"=>"You did not enable {$requiredTrait->name}"];
    }
    switch ($foundTrait['style']) {
        case 0:
            return ["success"=>false, "info"=>"You did not enable {$requiredTrait->name}"];

        case 1:
            if($level === 'bronze'){
                return ["success"=>true, "info"=>"{$requiredTrait->name} reached level Bronze"];
            }
            else{
                return ["success"=>false, "info"=>"{$requiredTrait->name} reached level Bronze"];
            }

        case 2:
            if($level === 'bronze' || $level === 'silver'){
                return ["success"=>true, "info"=>"{$requiredTrait->name} reached level Silver"];
            }
            else{
                return ["success"=>false, "info"=>"{$requiredTrait->name} reached level Silver"];
            }

        case 3:
            if($level === 'bronze' || $level === 'silver' || $level === 'gold'){
                return ["success"=>true, "info"=>"{$requiredTrait->name} reached level Gold"];
            }
            else{
                return ["success"=>false, "info"=>"{$requiredTrait->name} reached level Gold"];
            }

        case 4:
            return ["success"=>true, "info"=>"{$requiredTrait->name} reached level Chromatic"];


        default:
        return ["success"=>false, "info"=>"You did not enable {$requiredTrait->name}"];

    }
}

function verifyConstraint($requiredConstraint, $matchInfo)
{
    switch ($requiredConstraint['name']) {
        case "Hard stuck":
            $reachedLevel = $matchInfo["level"];
            return ["success"=>$reachedLevel===8, "info"=>"You reached level {$reachedLevel}"];

        case "Solo leveling":
            $reachedLevel = $matchInfo["level"];
            return ["success"=>$reachedLevel===10, "info"=>"You reached level {$reachedLevel}"];

        case "Greedy":
            $goldLeft = $matchInfo["gold_left"];
            return ["success"=>$goldLeft>=50, "info"=>"You had {$goldLeft} gold left"];

        case "Killer":
            $eliminations = $matchInfo["players_eliminated"];
            return ["success"=>$eliminations>=2, "info"=>"You eliminated {$eliminations} players"];

        case "Big D-DPS":
            $damages = $matchInfo["total_damage_to_players"];
            return ["success"=>$damages>=150, "info"=>"You inflicted {$damages} damages"];

        case "Rainbow":
            $validateTraits = collect($matchInfo['traits'])->filter(function ($trait) {
                return $trait['style'] >= 1;
            });
            $traitsNumber = count($validateTraits);
            return ["success"=>$traitsNumber>=6, "info"=>"You enabled {$traitsNumber} traits"];

        case "Legen... Dary":
            $units = $matchInfo["units"];
            $legendaries = count(collect($units)->where('rarity', 4));
            return ["success"=>$legendaries>=2, "info"=>"You played {$legendaries} lengary units"];

        case "Santa":
            $units = $matchInfo["units"];
            $noItemUnits = collect($units)->filter(function ($unit) {
                return empty($unit['itemNames']) || count($unit['itemNames']) === 0;
            });
            $numberNoItemUnits = count($noItemUnits);
            $unitNames = $noItemUnits
            ->pluck('character_id')
            ->map(function ($id) {
                return substr($id, 6);
            })
            ->implode(', ');
            return ["success"=>$numberNoItemUnits===0, "info"=>"{$unitNames} had no item"];

        case "Tenacity":
            $lastRound = $matchInfo["last_round"];
            $stage = formatRound($lastRound);
            return ["success"=>$lastRound>=32, "info"=>"You survived until {$stage}"];

        case "Overpopulated":
            $numberUnits = count($matchInfo["units"]);
            return ["success"=>$numberUnits>=10, "info"=>"Your board contained {$numberUnits} units"];

        default:
        return ["success"=>false, "info"=>"Unknow Constraint"];
        }

}

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();

        $latestChallenge = getActiveChallenge($user);
        if ($latestChallenge) {
            return redirect()->route('challenge.show', ['id' => $latestChallenge->id]);
        }

        return Inertia::render('Challenge/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $challenge = Challenge::with(['season', 'position', 'constraint', 'classe', 'origin'])->findOrFail($id);

        return Inertia::render('Challenge/Show', [
            'challenge' => $challenge,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $challenge = Challenge::findOrFail($id);
        $challenge->delete();

        return redirect()->route('homepage')->with('success', 'Challenge deleted');
    }

    public function getCurrentSeason()
    {
        return Season::where('active', true)->first();
    }

    public function generate()
    {
        $user = Auth::user();
        $latestChallenge = getActiveChallenge($user);
        if ($latestChallenge) {
            return redirect()->route('challenge.show', ['id' => $latestChallenge->id]);
        }

        $currentSeason = $this->getCurrentSeason();

        $challenge = [
            'position' => Position::inRandomOrder()->first(),
            'constraint' => Constraint::inRandomOrder()->first(),
            'classe' => Classe::where('season_id', $currentSeason->id)->inRandomOrder()->first(),
            'origin' => Origin::where('season_id', $currentSeason->id)->inRandomOrder()->first(),
        ];

        return Inertia::render('Challenge/Index', [
            'challenge' => $challenge,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }

    public function accept(Request $request)
    {
        $user = Auth::user();
        $latestChallenge = getActiveChallenge($user);
        if ($latestChallenge) {
            return redirect()->route('challenge.show', ['id' => $latestChallenge->id]);
        }

        $data = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'classe_id' => 'required|exists:classes,id',
            'origin_id' => 'required|exists:origins,id',
            'constraint_id' => 'required|exists:constraints,id',
        ]);

        $challenge = Challenge::create([
            'position_id' => $data['position_id'],
            'classe_id' => $data['classe_id'],
            'origin_id' => $data['origin_id'],
            'constraint_id' => $data['constraint_id'],
            'season_id' => $this->getCurrentSeason()->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('challenge.show', $challenge->id)->with('success', 'Challenge accepted and registered !');
    }

    public function complete(string $id)
    {
        $user = Auth::user();
        $riotUsername = urlencode($user->riot_username);

        $challenge = Challenge::where('user_id', $user->id)
            ->where('id', $id)
            ->with(['position', 'classe', 'origin', 'constraint'])
            ->firstOrFail();

        $puuid = getPuuidFromRiotId($riotUsername);

        if(!$puuid){
            return Inertia::render('Challenge/RiotIDError');
        }

        $match = getLastMatch($puuid);

        if(!$match){
            return Inertia::render('Challenge/RiotIDError');
        }

        $matchInfo = $match['matchInfo'];
        $matchID = $match['matchID'];
        $link = "https://www.metatft.com/player/euw/{$riotUsername}-EUW?match={$matchID}";

        $positionResult = verifyPosition($challenge->position, $matchInfo["placement"]);
        $traits = $matchInfo['traits'];
        $originResult = verifyTrait($challenge->origin, $traits, 'gold');
        $classeResult = verifyTrait($challenge->classe, $traits, 'bronze');
        $constraintResult = verifyConstraint($challenge->constraint, $matchInfo);
        $results = ["position"=>$positionResult, "classe"=>$classeResult, 'origin'=>$originResult,  "constraint"=>$constraintResult];

        $positionSuccess = $results["position"]["success"];
        $originSuccess = $results["origin"]["success"];
        $classeSuccess = $results["classe"]["success"];
        $constraintSuccess = $results["constraint"]["success"];
        $success = $positionSuccess && $originSuccess && $classeSuccess && $constraintSuccess;

        // dd($matchInfo);
        if (!$success) {
            return Inertia::render('Challenge/Fail', [
                'challenge' => $challenge,
                'results' => $results,
                'link' => $link,
            ]);
        }

        $challenge->status = 'completed';
        $challenge->match_id = $matchID;
        $challenge->save();

        $user->score = $user->score+1;
        $user->save();

        return Inertia::render('Challenge/Success', [
            'challenge' => $challenge,
            'results' => $results,
            'link' => $link,
        ]);
    }

}


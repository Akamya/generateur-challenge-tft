<script setup>
const props = defineProps({
    ranking: Number,
});

let rankingImage = null;

if (props.ranking <= 1) {
    rankingImage = "/storage/seed/rankings/Challenger.png";
} else if (props.ranking <= 2) {
    rankingImage = "/storage/seed/rankings/GrandMaster.png";
} else if (props.ranking <= 3) {
    rankingImage = "/storage/seed/rankings/Master.png";
} else if (props.ranking <= 5) {
    rankingImage = "/storage/seed/rankings/Diamond.png";
} else if (props.ranking <= 10) {
    rankingImage = "/storage/seed/rankings/Platinum.png";
} else if (props.ranking <= 20) {
    rankingImage = "/storage/seed/rankings/Gold.png";
} else if (props.ranking <= 50) {
    rankingImage = "/storage/seed/rankings/Silver.png";
} else if (props.ranking <= 100) {
    rankingImage = "/storage/seed/rankings/Bronze.png";
} else {
    rankingImage = "/storage/seed/rankings/Iron.png";
}
</script>

<template>
    <div>
        <img :src="rankingImage" alt="tft ranking logo" class="w-32 h-auto" />
    </div>
</template>

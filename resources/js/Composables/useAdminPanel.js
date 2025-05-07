import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";

export function useAdminPanel(props) {
    const activeTab = ref("seasons");
    const showSeasonModal = ref(false);
    const showClasseModal = ref(false);
    const showDeleteModal = ref(false);
    const selectedSeason = ref(null);
    const confirmationText = ref("");
    const isEditing = ref(false);
    const originallyActive = ref(false);

    const seasonForm = useForm({ id: null, name: "", active: false });
    const classeForm = useForm({ id: null, name: "", technical_name: "" });

    const canActivate = computed(
        () => !props.seasons.some((season) => season.active)
    );

    const openSeasonForm = (season = null) => {
        isEditing.value = !!season;
        if (season) {
            seasonForm.id = season.id;
            seasonForm.name = season.name;
            seasonForm.active = !!season.active;
            originallyActive.value = !!season.active;
        } else {
            seasonForm.reset();
        }
        showSeasonModal.value = true;
    };

    const openClasseForm = (classe = null) => {
        isEditing.value = !!classe;
        if (classe) {
            classeForm.id = classe.id;
            classeForm.name = classe.name;
            classeForm.technical_name = classe.technical_name;
        } else {
            classeForm.reset();
        }
        showClasseModal.value = true;
    };

    const openDeleteSeasonModal = (season) => {
        selectedSeason.value = season;
        confirmationText.value = "";
        showDeleteModal.value = true;
    };

    const confirmDelete = () => {
        if (confirmationText.value === "DELETE") {
            Inertia.delete(
                route("admin.season.delete", selectedSeason.value.id)
            );
            showDeleteModal.value = false;
        }
    };

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString("fr-FR", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    };

    return {
        activeTab,
        showSeasonModal,
        showClasseModal,
        showDeleteModal,
        selectedSeason,
        confirmationText,
        isEditing,
        originallyActive,
        seasonForm,
        classeForm,
        canActivate,
        openSeasonForm,
        openClasseForm,
        openDeleteSeasonModal,
        confirmDelete,
        formatDate,
    };
}

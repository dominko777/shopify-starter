<template>
    <div>
        ContactUs
    </div>
</template>

<script>
import Vuetable from "vuetable-2/src/components/Vuetable"
import VuetablePagination from "vuetable-2/src/components/VuetablePagination"
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo"


export default {
    components: {
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo
    },
    data() {
        return {
            reviews: [],
            getAllBook: {},
            fields: [
                {
                    name: "description",
                    title: "description"
                }
            ],
        };
    },
    methods: {
        loadReviews() {
            axios.get("reviews").then(({ data }) => (this.reviews = data));
        }
    },
    mounted() {
        this.loadReviews();
    }
};
</script>

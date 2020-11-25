<template>
    <div>
        asdasd!!!!!!!!!!!!!!!
        <!-- <vuetable ref="vuetable"
        api-url="https://vuetable.ratiw.net/api/users"
        :fields="['name', 'nickname', 'email', 'gender']"
        data-path=""
        pagination-path=""
      ></vuetable> -->
    </div>
</template>

<script>
import Vuetable from "vuetable-2/src/components/Vuetable"
import VuetablePagination from "vuetable-2/src/components/VuetablePagination"
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo"
console.log('2222222222Vue Component!!!!!!!!')


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
            axios.get("api/reviews").then(({ data }) => (this.reviews = data));
        }
    },
    mounted() {
        this.loadReviews();
    }
};
</script>

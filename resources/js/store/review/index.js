import Vue from "vue";

export default {
    state: {
        bookmarkState: false,
    },
    getters: {
        getBookmarkState: state => id => {
            return state.bookmarkState
        },
    },
    actions: {},
    mutations: {

        setCustomers(state, bookmarkState) {
            state.bookmarkState = bookmarkState;
        },
    },
};

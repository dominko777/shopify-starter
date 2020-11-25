import ReviewsIndex from '../components/reviews/index.vue';
import ContactUs from '../components/ContactUs.vue';

export const routes = [
    {
        path: '/',
        component: ReviewsIndex
    },
    {
        path: '/contactUs',
        component: ContactUs
    }
]
import ReviewsIndex from '../components/reviews/index.vue';
import ContactUs from '../components/ContactUs.vue';

export const routes = [
    {
        path: '/contactUs',
        component: ContactUs
    },
    {
        path: '/',
        component: ReviewsIndex,
        name: 'reviews',
    } 
]
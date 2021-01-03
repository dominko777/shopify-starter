import Reviews from '../components/reviews/index.vue';
import ContactUs from '../components/ContactUs.vue';
import Bookmarks from '../components/bookmarks/index.vue';
import Statistics from '../components/statistics/index.vue';

export const routes = [
    {
        path: '/contactUs',
        component: ContactUs
    },
    {
        path: '/bookmarks',
        component: Bookmarks,
        name: 'bookmarks',
    },
    {
        path: '/statistics',
        component: Statistics,
        name: 'statistics',
    },
    {
        path: '/',
        component: Reviews,
        name: 'reviews',
    }
]
import Reviews from '../components/reviews/index.vue';
import ContactUs from '../components/ContactUs.vue';
import Bookmarks from '../components/bookmarks/index.vue';
import Analytics from '../components/analytics/index.vue';
import Settings from '../components/settings/index.vue';

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
        path: '/analytics',
        component: Analytics,
        name: 'analytics',
    },
    {
        path: '/settings',
        component: Settings,
        name: 'settngs',
    },
    {
        path: '/',
        component: Reviews,
        name: 'reviews',
    }
]
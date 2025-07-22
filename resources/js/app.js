import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (window.location.pathname.startsWith('/admin')) {
    import.meta.glob('./admin/**/*.js', { eager: true });
}
import './customer/cart.js';



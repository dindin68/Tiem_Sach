import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const modules = import.meta.glob('./admin/**/*.js', { eager: true });


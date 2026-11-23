import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import contactForm from './contact-form';
import reveal from './reveal';

reveal();

Alpine.plugin(focus);
Alpine.data('contactForm', contactForm);

window.Alpine = Alpine;
Alpine.start();

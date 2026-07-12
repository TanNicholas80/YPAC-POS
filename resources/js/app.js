import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { createIcons, icons } from 'lucide';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Expose to window object for global availability in Blade templates
window.Swal = Swal;
window.lucide = {
    createIcons: (options = {}) => {
        createIcons({
            icons,
            ...options
        });
    }
};
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Automatically initialize Lucide Icons on DOM Load
document.addEventListener('DOMContentLoaded', () => {
    window.lucide.createIcons();
});

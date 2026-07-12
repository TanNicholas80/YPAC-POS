import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { createIcons, icons } from 'lucide';

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

// Automatically initialize Lucide Icons on DOM Load
document.addEventListener('DOMContentLoaded', () => {
    window.lucide.createIcons();
});

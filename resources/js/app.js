import Alpine from 'alpinejs';

// Alpine plugins.
import internationalNumber from "./plugins/internationalNumber";

require('./helpers');
require('./scrollspy');

// Add Alpine to window object.
window.Alpine = Alpine;

Alpine.data('internationalNumber', internationalNumber)

Alpine.start();

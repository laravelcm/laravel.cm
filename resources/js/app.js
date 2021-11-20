import Alpine from 'alpinejs'

import internationalNumber from './plugins/internationalNumber'
import './elements'
import './helpers'
import './editor'
import './scrollspy'

// Add Alpine to window object.
window.Alpine = Alpine;

Alpine.data('internationalNumber', internationalNumber)

Alpine.start();

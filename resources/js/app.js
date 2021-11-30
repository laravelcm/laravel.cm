import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'

import internationalNumber from './plugins/internationalNumber'
import './elements'
import './helpers'
import './editor'
import './scrollspy'

// Add Alpine to window object.
window.Alpine = Alpine;

Alpine.data('internationalNumber', internationalNumber)
Alpine.plugin(intersect)

Alpine.start();

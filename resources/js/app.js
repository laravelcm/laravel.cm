import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'

import internationalNumber from './plugins/internationalNumber'
import { registerHeader } from './header'
import './elements'
import './helpers'
import './editor'
import './scrollspy'
import './helpers/string'

registerHeader()

// Add Alpine to window object.
window.Alpine = Alpine;

Alpine.data('internationalNumber', internationalNumber)
Alpine.plugin(intersect)

Alpine.start();

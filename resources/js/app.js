import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'

import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import internationalNumber from './plugins/internationalNumber'
import { registerHeader } from './header'
import './elements'
import './helpers'
import './editor'
import './scrollspy'
import './helpers/string'

registerHeader()

Alpine.data('internationalNumber', internationalNumber)
Alpine.plugin(intersect)
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)

window.Alpine = Alpine;

Alpine.start();

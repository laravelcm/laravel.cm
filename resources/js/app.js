import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'

import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import internationalNumber from './plugins/internationalNumber'
import { registerHeader } from './header'
import './elements'
import './helpers'
import './editor'
import './scrollspy'
import './helpers/string'

registerHeader()

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(intersect)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.data('internationalNumber', internationalNumber)

window.Alpine = Alpine

Alpine.start()

import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'

import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import internationalNumber from './plugins/internationalNumber'
import { registerHeader } from '@helpers/header'
import '@helpers/helpers'
import '@helpers/scrollspy'
import './elements'
import './utils/editor'
import './utils/filepond'

registerHeader()

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(intersect)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.data('internationalNumber', internationalNumber)

window.Alpine = Alpine

Alpine.start()

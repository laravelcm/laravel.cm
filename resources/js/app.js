import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import Tooltip from '@ryangjchandler/alpine-tooltip'

import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import internationalNumber from './plugins/internationalNumber'
import datepicker from './plugins/datepicker'
import { registerHeader } from '@helpers/header'
import '@helpers/helpers'
import '@helpers/scrollspy'
import './elements'
import './utils/editor'
import './utils/filepond'
import './utils/clipboard'

registerHeader()

Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(intersect)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(Tooltip)
Alpine.data('internationalNumber', internationalNumber)
Alpine.data('datepicker', datepicker)

window.Alpine = Alpine

Alpine.start()

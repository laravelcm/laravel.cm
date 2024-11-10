import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'
import '../../vendor/laravelcm/livewire-slide-overs/resources/js/slide-over';

import intersect from '@alpinejs/intersect'
import Tooltip from '@ryangjchandler/alpine-tooltip'
import collapse from '@alpinejs/collapse'

import './elements'
import { registerHeader } from './utils/header'
import './utils/helpers'
import './utils/scrollspy'
import './utils/clipboard'

registerHeader()

Alpine.plugin(intersect)
Alpine.plugin(Tooltip)
Alpine.plugin(collapse)

window.Alpine = Alpine

Livewire.start()

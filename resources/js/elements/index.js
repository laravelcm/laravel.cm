import preactCustomElement from '@helpers/preact.js'

import { Testimonies } from '@components/Testimonies'
import { Confetti } from './Confetti'
import { TimeAgo } from './TimeAgo'
import { TimeCountdown } from './TimeCountdown'

customElements.define('con-fetti', Confetti)
customElements.define('time-ago', TimeAgo)
customElements.define('time-countdown', TimeCountdown)
preactCustomElement('testimonies-area', Testimonies, ['target'])

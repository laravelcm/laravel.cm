import preactCustomElement from '@helpers/preact.js'

import { Comments } from '@components/Comments'
import { Testimonies} from '@components/Testimonies'
import { Confetti } from './Confetti'
import { TimeAgo } from './TimeAgo'
import { TimeCountdown } from './TimeCountdown'

customElements.define('con-fetti', Confetti)
customElements.define('time-ago', TimeAgo)
customElements.define('time-countdown', TimeCountdown)
preactCustomElement('comments-area', Comments, ['target'])
preactCustomElement('testimonies-area', Testimonies)

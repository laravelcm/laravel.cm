import preactCustomElement from '@helpers/preact.js'
import { Comments } from '@components/Comments.jsx'
import { Confetti } from './Confetti.js'
import { TimeAgo } from './TimeAgo.js'
import { TimeCountdown } from './TimeCountdown.js'

customElements.define('con-fetti', Confetti)
customElements.define('time-ago', TimeAgo)
customElements.define('time-countdown', TimeCountdown)
preactCustomElement('comments-area', Comments, ['target'])

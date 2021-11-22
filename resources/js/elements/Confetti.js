import confetti from 'canvas-confetti'
import { windowHeight } from '@helpers/window.js'

export class Confetti extends HTMLElement {
  connectedCallback () {
    const rect = this.getBoundingClientRect()
    const y = (rect.top + rect.height / 2) / windowHeight()
    confetti({
      particleCount: 100,
      zIndex: 3000,
      spread: 90,
      disableForReducedMotion: true,
      origin: { y }
    })
  }
}

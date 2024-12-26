import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'
import '../../vendor/laravelcm/livewire-slide-overs/resources/js/slide-over';

import intersect from '@alpinejs/intersect'
import Tooltip from '@ryangjchandler/alpine-tooltip'
import collapse from '@alpinejs/collapse'

import './utils/helpers'
import './utils/scrollspy'
import './utils/clipboard'

Alpine.plugin(intersect)
Alpine.plugin(Tooltip)
Alpine.plugin(collapse)

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
  const theme =
    localStorage.getItem('theme') ??
    getComputedStyle(document.documentElement).getPropertyValue(
      '--default-theme-mode',
    )

  window.Alpine.store(
    'theme',
    theme === 'dark' ||
    (theme === 'system' &&
      window.matchMedia('(prefers-color-scheme: dark)').matches)
      ? 'dark'
      : 'light',
  )

  window.addEventListener('theme-changed', (event) => {
    let theme = event.detail

    localStorage.setItem('theme', theme)

    if (theme === 'system') {
      theme = window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark'
        : 'light'
    }

    window.Alpine.store('theme', theme)
  })

  window
    .matchMedia('(prefers-color-scheme: dark)')
    .addEventListener('change', (event) => {
      if (localStorage.getItem('theme') === 'system') {
        window.Alpine.store('theme', event.matches ? 'dark' : 'light')
      }
    })

  window.Alpine.effect(() => {
    const theme = window.Alpine.store('theme')

    theme === 'dark'
      ? document.documentElement.classList.add('dark')
      : document.documentElement.classList.remove('dark')
  })
})

Livewire.start()

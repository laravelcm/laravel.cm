import { fontFamily } from 'tailwindcss/defaultTheme'
import plugin from 'tailwindcss/plugin'
import colors from 'tailwindcss/colors'
import aspectRatio from '@tailwindcss/aspect-ratio'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  presets: [preset],
  content: [
    './app/**/*.php',
    './config/markdown.php',
    './resources/**/*.blade.php',
    './storage/framework/views/*.php',
    './vendor/filament/**/*.blade.php',
    './vendor/wire-elements/modal/resources/views/*.blade.php',
  ],
  safelist: [
    {
      pattern: /max-w-(xl|2xl|3xl|4xl|5xl|6xl)/,
      variants: ['sm', 'md', 'lg'],
    },
  ],
  theme: {
    extend: {
      animation: {
        'fade-in': 'fade-in 0.5s linear forwards',
        marquee: 'marquee var(--marquee-duration) linear infinite',
        'spin-slow': 'spin 4s linear infinite',
        'spin-slower': 'spin 6s linear infinite',
        'spin-reverse': 'spin-reverse 1s linear infinite',
        'spin-reverse-slow': 'spin-reverse 4s linear infinite',
        'spin-reverse-slower': 'spin-reverse 6s linear infinite',
        'scroll-slow': 'scroll 30s linear infinite',
      },
      keyframes: {
        'fade-in': {
          from: {
            opacity: 0,
          },
          to: {
            opacity: 1,
          },
        },
        marquee: {
          '100%': {
            transform: 'translateY(-50%)',
          },
        },
        'spin-reverse': {
          to: {
            transform: 'rotate(-360deg)',
          },
        },
        scroll: {
          from: {
            transform: 'translateX(0)',
          },
          to: {
            transform: 'translateX(-100%)',
          }
        }
      },
      colors: {
        flag: {
          green: '#099170',
          red: '#e21b30',
          yellow: '#ffdc44',
        },
        black: '#161B22',
        green: colors.emerald,
        primary: colors.emerald,
      },
      fontFamily: {
        heading: ['Lexend', ...fontFamily.sans],
        mono: ['JetBrains Mono', ...fontFamily.mono],
        sans: ['DM Sans', ...fontFamily.sans],
      },
      width: {
        90: '22.5rem'
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            img: {
              borderRadius: theme('borderRadius.lg')
            },
            'h1, h2, h3, h4': {
              fontFamily: "Lexend, sans-serif",
            },
            blockquote: {
              fontStyle: 'normal',
            },
            'blockquote p:first-of-type::before': {
              content: 'none',
            },
            'blockquote p:first-of-type::after': {
              content: 'none',
            },
            'pre, code, p > code': {
              fontWeight: theme('fontWeight.medium'),
              fontFamily: 'JetBrains Mono, monospace',
              color: theme('colors.amber.500'),
            },
            'li strong, strong' : {
              color: theme('colors.gray.700'),
              fontWeight: 400
            },
          },
        },
      })
    },
  },
  plugins: [
    aspectRatio,
    forms,
    typography,
    plugin(({ matchUtilities }) => {
      matchUtilities({
        replace: (value) => ({
          [`@apply ${value.replaceAll(',', ' ')}`]: {},
        }),
      })
    }),
  ],
}

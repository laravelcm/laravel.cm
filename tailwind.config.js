const { fontFamily } = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

function withOpacity(variableName) {
  return ({ opacityValue }) => {
    if (opacityValue !== undefined) {
      return `rgba(var(${variableName}), ${opacityValue})`
    }
    return `rgb(var(${variableName}))`
  }
}

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './app/**/*.php',
    './config/markdown.php',
    './resources/**/*.blade.php',
    './resources/**/*.{js,jsx}',
    './storage/framework/views/*.php',
    './vendor/filament/**/*.blade.php',
    './vendor/wire-elements/modal/resources/views/*.blade.php',
  ],
  safelist: [
    {
      pattern: /max-w-(xl|2xl|3xl|4xl)/,
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
        body: 'rgb(var(--color-body-fill))',
        card: 'rgb(var(--color-card-fill))',
        green: colors.emerald,
        danger: colors.rose,
        primary: colors.emerald,
        success: colors.green,
        warning: colors.yellow,
      },
      fontFamily: {
        heading: ['Lexend', ...fontFamily.sans],
        mono: ['JetBrains Mono', ...fontFamily.mono],
        sans: ['DM Sans', ...fontFamily.sans],
      },
      textColor: {
        skin: {
          primary: withOpacity('--color-text-primary'),
          'primary-hover': withOpacity('--color-text-primary-hover'),
          menu: withOpacity('--color-text-link-menu'),
          'menu-hover': withOpacity('--color-text-link-menu-hover'),
          base: withOpacity('--color-text-base'),
          muted: withOpacity('--color-text-muted'),
          inverted: withOpacity('--color-text-inverted'),
          'inverted-muted': withOpacity('--color-text-inverted-muted'),
        }
      },
      backgroundColor: {
        skin: {
          primary: withOpacity('--color-text-primary'),
          link: withOpacity('--color-link-fill'),
          menu: withOpacity('--color-menu-fill'),
          body: withOpacity('--color-body-fill'),
          footer: withOpacity('--color-footer-fill'),
          'footer-light': withOpacity('--color-footer-light-fill'),
          input: withOpacity('--color-input-fill'),
          button: withOpacity('--color-button-default'),
          'button-hover': withOpacity('--color-card-muted-fill'),
          card: withOpacity('--color-card-fill'),
          'card-gray': withOpacity('--color-card-gray'),
          'card-muted': withOpacity('--color-card-muted-fill'),
        }
      },
      borderColor: {
        skin: {
          base: withOpacity('--color-border'),
          input: withOpacity('--color-input-border'),
        }
      },
      divideColor: {
        skin: {
          base: withOpacity('--color-divide'),
          light: withOpacity('--color-divide-light'),
        }
      },
      placeholderColor: {
        skin: {
          input: withOpacity('--color-text-muted'),
          'input-focus': withOpacity('--color-text-base'),
        }
      },
      width: {
        90: '22.5rem'
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: theme('textColor.skin.base'),
            a: {
              textDecoration: 'none',
              color: theme('textColor.skin.primary'),
              '&:hover': {
                color: theme('textColor.skin.primary-hover'),
              },
            },
            img: {
              borderRadius: theme('borderRadius.lg')
            },
            'h1, h2, h3, h4': {
              color: theme('textColor.skin.inverted'),
              fontFamily: "Lexend, sans-serif",
            },
            hr: {
              borderColor: theme('borderColor.skin.base')
            },
            blockquote: {
              color: theme('textColor.skin.inverted'),
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
              color: theme('textColor.skin.inverted-muted'),
              fontWeight: 400
            },
          },
        },
      })
    },
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}

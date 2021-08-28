const defaultTheme = require('tailwindcss/defaultTheme');

function withOpacity(variableName) {
  return ({ opacityValue }) => {
    if (opacityValue !== undefined) {
      return `rgba(var(${variableName}), ${opacityValue})`
    }
    return `rgb(var(${variableName}))`
  }
}

module.exports = {
  mode: 'jit',
  purge: {
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
    ],
    safelist: [

    ],
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        flag: {
          green: '#099170',
          red: '#e21b30',
          yellow: '#ffdc44',
        },
        body: 'rgb(var(--color-body-fill))',
      },
      fontFamily: {
        mono: ['Operator Mono', ...defaultTheme.fontFamily.mono],
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
      fontWeight: {
        normal: 300
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
          link: withOpacity('--color-link-fill'),
          menu: withOpacity('--color-menu-fill'),
          body: withOpacity('--color-body-fill'),
          footer: withOpacity('--color-footer-fill'),
          'footer-light': withOpacity('--color-footer-light-fill'),
          input: withOpacity('--color-input-fill'),
          button: withOpacity('--color-button-default'),
          'button-hover': withOpacity('--color-card-muted-fill'),
          card: withOpacity('--color-card-fill'),
          'card-muted': withOpacity('--color-card-muted-fill'),
        }
      },
      borderColor: {
        skin: {
          base: withOpacity('--color-border'),
          light: withOpacity('--color-border-light'),
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
            'h1, h2, h3, h4': {
              color: theme('textColor.skin.inverted'),
              fontFamily: "'Inter var', serif"
            },
            p: {
              fontWeight: 300
            },
            hr: {
              borderColor: theme('borderColor.skin.base')
            },
            blockquote: {
              color: theme('textColor.skin.inverted')
            }
          },
        },
      }),
      width: {
        90: '22.5rem'
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
    require('@tailwindcss/typography'),
  ],
}

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
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        flag: {
          green: '#099170',
          red: '#e21b30',
          yellow: '#ffdc44',
        }
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
      typography: {
        DEFAULT: {
          css: {
            a: {
              textDecoration: 'none'
            },
          },
        },
      },
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

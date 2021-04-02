const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        brand: {
          green: '#099170',
          red: '#e21b30',
          yellow: '#ffdc44',
        }
      },
      fontFamily: {
        sans: ['Operator Mono', ...defaultTheme.fontFamily.sans],
        heading: ['Inter var', ...defaultTheme.fontFamily.mono],
      },
      typography: {
        DEFAULT: {
          css: {
            a: {
              textDecoration: 'none'
            },
          },
        },
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

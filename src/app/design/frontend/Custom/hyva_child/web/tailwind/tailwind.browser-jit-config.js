// Only these two imports are supported in browser context
// Other require() calls will fail in the browser-based compiler
const { spacing } = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  theme: {
    // Override default container behavior for CMS content
    container: {
      center: true,
      padding: spacing["6"]
    },
    extend: {
        colors: {
            // Custom color definitions available in CMS content
            // These must match your theme's color palette
            'my-gray': '#888877',
            primary: {
                lighter: colors.purple['300'],
                "DEFAULT": colors.purple['800'],
                darker: colors.purple['900'],
            },
        }
    },
  }
}
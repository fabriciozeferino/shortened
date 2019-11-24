module.exports = {
    theme: {
        extend: {
            fontFamily: {
                display: ['Source Sans Pro', 'sans-serif'],
                body: ['Source Sans Pro', 'sans-serif'],
            },
            fontSize: {
                'title': '22pt',
                'link': '18pt',
                'body': '14pt',
            },
            spacing: {
                logo: '100px',
                navbar: '200px'
            },
            colors: {
                gray: '#555555',
                lightgray: '#eeeeee',
                blue: {
                    lighter: '#4577a1',
                    default: '#2979bc',
                    dark: '#2C5282',
                }
            }
        },

    },
    variants: {
        placeholderColor: ['responsive', 'hover', 'focus', 'active']
    },
    plugins: []
}

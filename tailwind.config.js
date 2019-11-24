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
                blue: '#2979bc',
            }
        },

    },
    variants: {
        placeholderColor: ['responsive', 'hover', 'focus', 'active']
    },
    plugins: []
}

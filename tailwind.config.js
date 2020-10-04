module.exports = {
    purge: [],
    theme: {
        extend: {
            colors: {
                primary: {
                    100: '#dbccff',
                    200: '#cbb5ff',
                    300: '#bda1ff',
                    400: '#af8cff',
                    500: '#a078ff',
                    600: '#9263ff',
                    700: '#844fff',
                    800: '#763bff',
                    900: '#6927ff',
                },
                secondary: {
                    100: '#c8b8d9',
                    200: '#c0a9d9',
                    300: '#b99cd9',
                    400: '#b38fd9',
                    500: '#ac82d9',
                    600: '#a575d9',
                    700: '#9d66d9',
                    800: '#9759d9',
                    900: '#914cd9',
                },
                success: {
                    100: '#d1e5be',
                    200: '#c7e5aa',
                    300: '#bce595',
                    400: '#b1e581',
                    500: '#a8e56e',
                    600: '#9de55a',
                    700: '#93e545',
                    800: '#89e532',
                    900: '#7ce61e',
                },
                info: {
                    100: '#abc9d1',
                    200: '#99c5d1',
                    300: '#86c1d1',
                    400: '#73bdd1',
                    500: '#62b9d1',
                    600: '#4fb5d1',
                    700: '#3db1d1',
                    800: '#2cadd1',
                    900: '#19aad1',
                },
                warning: {
                    100: '#ffefcf',
                    200: '#ffebc4',
                    300: '#ffe9bd',
                    400: '#ffe5b2',
                    500: '#ffe2a8',
                    600: '#ffdf9e',
                    700: '#ffdb94',
                    800: '#ffd88a',
                    900: '#ffd581',
                },
                danger: {
                    100: '#ffcce2',
                    200: '#ffb8d7',
                    300: '#ffa3cb',
                    400: '#ff8fbf',
                    500: '#ff7ab4',
                    600: '#ff66a8',
                    700: '#ff529d',
                    800: '#ff3b90',
                    900: '#ff2783',
                },
                'primary-dark': {
                    100: '#433745',
                    200: '#433445',
                    300: '#423045',
                    400: '#412b45',
                    500: '#412845',
                    600: '#402445',
                    700: '#402045',
                    800: '#3f1c45',
                    900: '#3f1845',
                },
                gray: {
                    100: '#fcfcfc',
                    200: '#f7f7f7',
                    300: '#f0f0f0',
                    400: '#e0e0e0',
                    450: '#cccccc',
                    500: '#bfbfbf',
                    600: '#969696',
                    700: '#696969',
                    800: '#474747',
                    900: '#2b2b2b',
                },
            },
            fontFamily: {
                'sans': ['Nunito', 'sans-serif'],
            },
            fontSize: {
                xs: '0.75rem',
                sm: '0.875rem',
                base: '1rem',
                lg: '1.125rem',
                xl: '1.25rem',
                '2xl': '1.5rem',
                '3xl': '1.875rem',
                '4xl': '2.25rem',
                '5xl': '3rem',
                '6xl': '4rem',
                '7xl': '5rem',
                '8xl': '6rem',
                '9xl': '7rem',
                '10xl': '8rem',
                '11xl': '9rem',
                '12xl': '10rem',
            },
        },
    },
    variants: {},
    plugins: [
        require('tailwindcss-shadow-outline-colors')(),
    ],
}

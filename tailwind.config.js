import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            
            // --- PALETA DE COLORES PERSONALIZADA (Verde Petróleo + Blanco Humo) ---
            colors: {
                // 1. COLOR PRINCIPAL (Verde Petróleo #315762)
                // Usado para: Sidebar activo, botones, textos destacados.
                primary: {
                    DEFAULT: '#315762', 
                    50: '#F2F7F8',
                    100: '#DDECEE',
                    200: '#BDDBE0',
                    300: '#91C2C9',
                    400: '#62A3AE',
                    500: '#438591',
                    600: '#315762', // TU COLOR BASE
                    700: '#2A4751',
                    800: '#263D45',
                    900: '#22343B',
                    950: '#131F24',
                },

                // 2. COLOR SECUNDARIO / GRISES (Para textos y bordes)
                // Usamos la gama de grises fríos de Tailwind que combina bien con el verde
                secondary: {
                    DEFAULT: '#EFEFEF',
                    50: '#FAFAFA',
                    100: '#F5F5F5',
                    200: '#EFEFEF', // TU COLOR BASE (Fondo claro)
                    300: '#D4D4D4',
                    400: '#A3A3A3',
                    500: '#737373',
                    600: '#525252',
                    700: '#404040',
                    800: '#262626',
                    900: '#171717',
                },

                // Fondo general de la aplicación
                background: '#EFEFEF', 
                surface: '#FFFFFF',    
            }
        },
    },

    plugins: [forms],
};
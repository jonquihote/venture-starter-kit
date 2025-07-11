import themer from 'tailwindcss-themer';
import colors from 'tailwindcss/colors';
import preset from './vendor/filament/filament/tailwind.config.preset.js';

export default {
    presets: [preset],

    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './modules/**/resources/views/**/*.blade.php',
    ],

    safelist: [
        //

        'fi-panel-home',
        'fi-panel-guide',
    ],

    plugins: [
        themer({
            defaultTheme: {
                extend: {
                    colors: {
                        secondary: colors.slate,
                        success: colors.emerald,
                        danger: colors.rose,
                        warning: colors.amber,
                        info: colors.blue,
                    },
                },
            },
            themes: [
                {
                    name: 'fi-panel-home',
                    extend: {
                        colors: {
                            primary: colors.orange,
                        },
                    },
                },
                {
                    name: 'fi-panel-guide',
                    extend: {
                        colors: {
                            primary: colors.stone,
                        },
                    },
                },
            ],
        }),
    ],
};

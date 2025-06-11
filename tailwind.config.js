import preset from './vendor/filament/filament/tailwind.config.preset.js';

export default {
    presets: [preset],

    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './modules/**/resources/views/**/*.blade.php',
    ],
};

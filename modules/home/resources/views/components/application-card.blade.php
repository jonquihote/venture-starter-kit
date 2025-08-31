@props(['application'])

@php
    $route = $application->page::getRouteName(filament()->getPanel($application->slug));
    $url = route($route, [filament()->getTenant()]);
    $applicationThemeClass = "{$application->slug}-application-tile";
@endphp

<a
    href="{{ $url }}"
    wire:navigate.hover
    @class([
        // Flexbox
        'flex flex-col items-center',

        // Interaction
        'group',

        // Transitions
        'transition-all duration-200',
    ])
>
    {{-- Square colored tile --}}
    <div
        @class([
            // Layout & Sizing
            'aspect-square w-full',

            // Flexbox
            'flex items-center justify-center',

            // Visual
            'rounded-xl shadow-md',

            // Colors & Themes
            $applicationThemeClass,
            'default-application-tile',

            // Hover Effects
            'group-hover:scale-105 group-hover:shadow-lg',

            // Transitions
            'transition-all duration-300',
        ])
    >
        @svg($application->icon, implode(' ', [
            // Sizing
            'h-10 w-10',

            // Colors
            'text-white',

            // Transitions
            'transition-transform duration-200',
        ]))
    </div>

    {{-- Uppercase label --}}
    <div
        @class([
            // Flexbox
            'flex flex-col items-center',

            // Spacing
            'mt-2',
        ])
    >
        <span
            @class([
                // Typography
                'text-sm leading-none font-semibold tracking-wider uppercase',

                // Colors - Light Mode
                'text-gray-700 group-hover:text-gray-900',

                // Colors - Dark Mode
                'dark:text-gray-300 dark:group-hover:text-gray-100',

                // Transitions
                'transition-colors duration-200',
            ])
        >
            {{ $application->name }}
        </span>
    </div>
</a>

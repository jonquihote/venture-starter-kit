<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $totalSlots = 15;
            $placeholderSlots = max(0, $totalSlots - $applications->count());
        @endphp

        <div
            @class([
                // Grid Layout
                'grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8',

                // Spacing
                'gap-8',
            ])
        >
            {{-- Registered applications --}}
            @foreach ($applications as $application)
                <x-home::application-card :application="$application" />
            @endforeach

            {{-- Empty placeholder slots --}}
            @for ($i = 0; $i < $placeholderSlots; $i++)
                <div
                    @class([
                        // Flexbox
                        'flex flex-col items-center',

                        // Transitions
                        'transition-all duration-200',
                    ])
                >
                    <div
                        @class([
                            // Layout & Sizing
                            'aspect-square w-full',

                            // Flexbox
                            'flex items-center justify-center',

                            // Visual
                            'application-placeholder rounded-xl',

                            // Hover Effects
                            'hover:scale-105',

                            // Transitions
                            'transition-all duration-300',
                        ])
                    >
                        @svg('lucide-app-window', implode(' ', [
                            // Sizing
                            'h-10 w-10',

                            // Colors
                            'text-gray-400 dark:text-gray-500',

                            // Transitions
                            'transition-transform duration-200',
                        ]))
                    </div>
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
                                'text-sm leading-none font-medium tracking-wider uppercase',

                                // Colors
                                'text-gray-400 dark:text-gray-500',

                                // Opacity
                                'opacity-60',
                            ])
                        >
                            Available
                        </span>
                    </div>
                </div>
            @endfor
        </div>

        @if ($applications->isEmpty())
            <div
                @class([
                    // Layout
                    'mt-8 text-center',
                ])
            >
                <h3
                    @class([
                        // Typography
                        'text-lg font-medium',

                        // Colors
                        'text-gray-900 dark:text-gray-100',

                        // Spacing
                        'mb-2',
                    ])
                >
                    {{ __('home::filament/widgets/active-applications-overview.empty_state.heading') }}
                </h3>
                <p
                    @class([
                        // Colors
                        'text-gray-500 dark:text-gray-400',
                    ])
                >
                    {{ __('home::filament/widgets/active-applications-overview.empty_state.description') }}
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>

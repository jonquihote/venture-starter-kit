<x-filament-widgets::widget>
    <x-filament::section>
        <div
            @class([
                'grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4', // Grid Layout
                'gap-6',                                                           // Spacing
            ])
        >
            @foreach ($groups as $group)
                <div
                    @class([
                        'flex flex-col items-center',                                    // Flexbox
                        'rounded-xl border border-gray-200 dark:border-gray-700',       // Border & Background
                        'bg-white dark:bg-gray-800',                                    // Background
                        'hover:shadow-md',                                              // Hover Effects
                        'transition-all duration-200',                                  // Transitions
                        'group',                                                        // Group
                    ])
                >
                    {{-- Icon Section --}}
                    <div
                        @class([
                            'flex items-center justify-center',                         // Layout & Sizing
                            'h-32 w-full',                                                // Sizing
                            'rounded-t-lg',                                               // Visual
                            $group['color'],                                            // Dynamic background color
                            'text-white',                                               // Icon Color
                        ])
                    >
                        @svg($group['icon'], implode(' ', [
                            'h-16 w-16', // Sizing
                            'group-hover:h-20 group-hover:w-20', // Hover effects
                            'transition-all',
                        ]))
                    </div>

                    {{-- Title Section --}}
                    <div
                        @class([
                            'text-center', // Text Alignment
                            'py-2', // Spacing
                        ])
                    >
                        <h3
                            @class([
                                'text-sm font-medium uppercase',                                      // Typography
                                'text-gray-900 dark:text-gray-100',                        // Colors
                            ])
                        >
                            {{ $group['name'] }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

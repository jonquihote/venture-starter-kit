<div
    @class([
        'mt-16',                            // Top Spacing
        'grid grid-cols-1 sm:grid-cols-2',  // Grid Layout
        'gap-8',                            // Spacing
    ])
>
    {{-- Previous Post Link --}}
    @if ($previousPost)
        <a
            href="{{ $previousPost->getUrl() }}"
            @class([
                'group block',                         // Display & Group
                'rounded-lg',                          // Border Radius
                'border',                              // Borders
                'border-gray-200 dark:border-gray-700',                      // Border Colors
                'px-6 py-8',                           // Spacing
                'text-left',                           // Text Alignment
                'hover:bg-gray-100/50 dark:hover:bg-gray-800/50',                // Hover Background
                'focus-visible:outline-primary',       // Focus Styles
                'transition-colors',                   // Transitions
            ])
        >
            <div
                @class([
                    'mb-4',               // Spacing
                    'text-sm',            // Typography Size
                    'font-medium',        // Typography Weight
                    'text-gray-600 dark:text-gray-400',   // Colors
                ])
            >
                @svg('lucide-chevron-left', 'h-6 w-6')
            </div>
            <p
                @class([
                    'truncate',           // Text Overflow
                    'text-[15px]',        // Typography Size
                    'font-medium',        // Typography Weight
                    'text-gray-900 dark:text-gray-100',   // Colors
                ])
            >
                {{ $previousPost->title }}
            </p>
        </a>
    @else
        <div></div>
        {{-- Empty placeholder for grid alignment --}}
    @endif

    {{-- Next Post Link --}}
    @if ($nextPost)
        <a
            href="{{ $nextPost->getUrl() }}"
            @class([
                'group block',                         // Display & Group
                'rounded-lg',                          // Border Radius
                'border',                              // Borders
                'border-gray-200 dark:border-gray-700',                      // Border Colors
                'px-6 py-8',                           // Spacing
                'text-right',                          // Text Alignment
                'hover:bg-gray-100/50 dark:hover:bg-gray-800/50',                // Hover Background
                'focus-visible:outline-primary',       // Focus Styles
                'transition-colors',                   // Transitions
            ])
        >
            <div
                @class([
                    'mb-4',               // Spacing
                    'text-sm',            // Typography Size
                    'font-medium',        // Typography Weight
                    'text-gray-600 dark:text-gray-400',   // Colors
                    'flex justify-end',   // Align icon to right
                ])
            >
                @svg('lucide-chevron-right', 'h-6 w-6')
            </div>
            <p
                @class([
                    'truncate',           // Text Overflow
                    'text-[15px]',        // Typography Size
                    'font-medium',        // Typography Weight
                    'text-gray-900 dark:text-gray-100',   // Colors
                ])
            >
                {{ $nextPost->title }}
            </p>
        </a>
    @else
        <div></div>
        {{-- Empty placeholder for grid alignment --}}
    @endif
</div>

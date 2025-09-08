<div
    @class([
        'grid grid-cols-1 sm:grid-cols-2', // Grid Layout
        'gap-8',                            // Spacing
    ])
>
    <span
        @class([
            'hidden lg:block', // Display & Visibility
        ])
    >
        &nbsp;
    </span>

    <a
        href="#getting-started"
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
        <p
            @class([
                'mb-1',               // Spacing
                'truncate',           // Text Overflow
                'text-[15px]',        // Typography Size
                'font-medium',        // Typography Weight
                'text-gray-900 dark:text-gray-100',   // Colors
            ])
        >
            Getting Started
        </p>
        <p
            @class([
                'text-sm',      // Typography Size
                'text-gray-600 dark:text-gray-400',   // Colors
                'line-clamp-2', // Text Overflow
            ])
        >
            Learn how to set up and start using the Venture Starter Kit.
        </p>
    </a>
</div>

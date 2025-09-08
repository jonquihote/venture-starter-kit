<aside
    @class([
        'hidden lg:block',                              // Display & Visibility
        'overflow-y-auto',                               // Overflow
        'lg:sticky lg:top-16',                          // Positioning
        'lg:max-h-[calc(100vh-4rem)] lg:w-64',          // Sizing
        'lg:-ms-4 lg:ps-4 lg:pe-6',                     // Spacing
        'lg:shrink-0',                                  // Flex Properties
    ])
>
    <div @class([
        'relative',  // Positioning
    ])>
        <nav>
            <ul
                @class([
                    'isolate',            // Display
                    '-mx-2.5 -mt-1.5',   // Spacing
                ])
            >
                <li
                    data-state="open"
                    data-orientation="vertical"
                    @class([
                        'flex flex-col',              // Layout
                        'data-[state=open]:mb-1.5',  // Conditional Spacing
                    ])
                >
                    <button
                        type="button"
                        aria-expanded="true"
                        data-state="open"
                        @class([
                            'group relative flex w-full items-center', // Layout
                            'gap-1.5 px-2.5 py-1.5',                   // Spacing
                            'text-sm font-semibold',                    // Typography
                            'text-gray-600 dark:text-gray-400',                               // Colors
                            'hover:text-gray-900 dark:hover:text-gray-100',                   // Hover Colors
                            'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',       // State Colors
                            'focus:outline-none focus-visible:outline-none', // Focus Reset
                            'focus-visible:ring-primary focus-visible:before:ring-primary', // Focus Styles
                            'transition-colors',                        // Transitions
                            'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo-element Position
                            'before:rounded-md before:transition-colors', // Pseudo-element Styles
                            'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',              // Pseudo-element Hover
                            'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo-element Focus
                        ])
                    >
                        <span
                            @class([
                                'truncate', // Text Overflow
                            ])
                        >
                            Getting Started
                        </span>
                    </button>
                    <div
                        role="region"
                        data-orientation="vertical"
                        @class([
                            'overflow-hidden',                                              // Overflow
                            'focus:outline-none',                                          // Focus Styles
                            'data-[state=closed]:animate-[accordion-up_200ms_ease-out]',   // Conditional Animation
                            'data-[state=open]:animate-[accordion-down_200ms_ease-out]',   // Conditional Animation
                        ])
                        data-state="open"
                    >
                        <ul
                            @class([
                                'ms-5',             // Spacing
                                'border-s',         // Borders
                                'border-gray-200 dark:border-gray-700',   // Border Colors
                            ])
                        >
                            <li
                                @class([
                                    '-ms-px ps-1.5', // Spacing
                                ])
                            >
                                <a
                                    href="#introduction"
                                    @class([
                                        'group relative flex w-full items-center',      // Layout
                                        'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                        'text-sm',                                       // Typography
                                        'text-gray-600 dark:text-gray-400',                                    // Colors
                                        'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                        'data-[state=active]:text-primary',              // Active Colors
                                        'focus:outline-none focus-visible:outline-none', // Focus Reset
                                        'focus-visible:before:ring-primary',             // Focus Styles
                                        'transition-colors',                             // Transitions
                                        'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                        'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                        'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',                   // Pseudo Before Hover
                                        'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                        'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                        'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                        'after:transition-colors',                       // Pseudo After Transitions
                                        'data-[state=active]:after:bg-primary',          // Pseudo After Active
                                    ])
                                >
                                    <span
                                        @class([
                                            'truncate', // Text Overflow
                                        ])
                                    >
                                        Introduction
                                    </span>
                                </a>
                            </li>
                            <li
                                @class([
                                    '-ms-px ps-1.5', // Spacing
                                ])
                            >
                                <a
                                    href="#getting-started"
                                    @class([
                                        'group relative flex w-full items-center',      // Layout
                                        'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                        'text-sm',                                       // Typography
                                        'text-gray-600 dark:text-gray-400',                                    // Colors
                                        'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                        'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',            // State Colors
                                        'focus:outline-none focus-visible:outline-none', // Focus Reset
                                        'focus-visible:before:ring-primary',             // Focus Styles
                                        'transition-colors',                             // Transitions
                                        'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                        'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                        'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',                   // Pseudo Before Hover
                                        'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                        'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                        'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                        'after:transition-colors',                       // Pseudo After Transitions
                                    ])
                                >
                                    <span
                                        @class([
                                            'truncate', // Text Overflow
                                        ])
                                    >
                                        Installation
                                    </span>
                                </a>
                            </li>
                            <li
                                @class([
                                    '-ms-px ps-1.5', // Spacing
                                ])
                            >
                                <a
                                    href="#development-workflow"
                                    @class([
                                        'group relative flex w-full items-center',      // Layout
                                        'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                        'text-sm',                                       // Typography
                                        'text-gray-600 dark:text-gray-400',                                    // Colors
                                        'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                        'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',            // State Colors
                                        'focus:outline-none focus-visible:outline-none', // Focus Reset
                                        'focus-visible:before:ring-primary',             // Focus Styles
                                        'transition-colors',                             // Transitions
                                        'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                        'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                        'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',                   // Pseudo Before Hover
                                        'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                        'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                        'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                        'after:transition-colors',                       // Pseudo After Transitions
                                    ])
                                >
                                    <span
                                        @class([
                                            'truncate', // Text Overflow
                                        ])
                                    >
                                        Development
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    data-state="open"
                    data-orientation="vertical"
                    @class([
                        'flex flex-col',              // Layout
                        'data-[state=open]:mb-1.5',  // Conditional Spacing
                    ])
                >
                    <button
                        type="button"
                        aria-expanded="true"
                        data-state="open"
                        @class([
                            'group relative flex w-full items-center', // Layout
                            'gap-1.5 px-2.5 py-1.5',                   // Spacing
                            'text-sm font-semibold',                    // Typography
                            'text-gray-600 dark:text-gray-400',                               // Colors
                            'hover:text-gray-900 dark:hover:text-gray-100',                   // Hover Colors
                            'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',       // State Colors
                            'focus:outline-none focus-visible:outline-none', // Focus Reset
                            'focus-visible:ring-primary focus-visible:before:ring-primary', // Focus Styles
                            'transition-colors',                        // Transitions
                            'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo-element Position
                            'before:rounded-md before:transition-colors', // Pseudo-element Styles
                            'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',              // Pseudo-element Hover
                            'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo-element Focus
                        ])
                    >
                        <span
                            @class([
                                'truncate', // Text Overflow
                            ])
                        >
                            Architecture
                        </span>
                    </button>
                    <div
                        role="region"
                        data-orientation="vertical"
                        @class([
                            'overflow-hidden',                                              // Overflow
                            'focus:outline-none',                                          // Focus Styles
                            'data-[state=closed]:animate-[accordion-up_200ms_ease-out]',   // Conditional Animation
                            'data-[state=open]:animate-[accordion-down_200ms_ease-out]',   // Conditional Animation
                        ])
                        data-state="open"
                    >
                        <ul
                            @class([
                                'ms-5',             // Spacing
                                'border-s',         // Borders
                                'border-gray-200 dark:border-gray-700',   // Border Colors
                            ])
                        >
                            <li
                                @class([
                                    '-ms-px ps-1.5', // Spacing
                                ])
                            >
                                <a
                                    href="#technology-stack"
                                    @class([
                                        'group relative flex w-full items-center',      // Layout
                                        'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                        'text-sm',                                       // Typography
                                        'text-gray-600 dark:text-gray-400',                                    // Colors
                                        'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                        'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',            // State Colors
                                        'focus:outline-none focus-visible:outline-none', // Focus Reset
                                        'focus-visible:before:ring-primary',             // Focus Styles
                                        'transition-colors',                             // Transitions
                                        'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                        'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                        'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',                   // Pseudo Before Hover
                                        'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                        'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                        'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                        'after:transition-colors',                       // Pseudo After Transitions
                                    ])
                                >
                                    <span
                                        @class([
                                            'truncate', // Text Overflow
                                        ])
                                    >
                                        Technology Stack
                                    </span>
                                </a>
                            </li>
                            <li
                                @class([
                                    '-ms-px ps-1.5', // Spacing
                                ])
                            >
                                <a
                                    href="#module-architecture"
                                    @class([
                                        'group relative flex w-full items-center',      // Layout
                                        'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                        'text-sm',                                       // Typography
                                        'text-gray-600 dark:text-gray-400',                                    // Colors
                                        'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                        'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',            // State Colors
                                        'focus:outline-none focus-visible:outline-none', // Focus Reset
                                        'focus-visible:before:ring-primary',             // Focus Styles
                                        'transition-colors',                             // Transitions
                                        'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                        'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                        'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',                   // Pseudo Before Hover
                                        'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                        'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                        'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                        'after:transition-colors',                       // Pseudo After Transitions
                                    ])
                                >
                                    <span
                                        @class([
                                            'truncate', // Text Overflow
                                        ])
                                    >
                                        Module System
                                    </span>
                                </a>
                            </li>
                            <li
                                @class([
                                    '-ms-px ps-1.5', // Spacing
                                ])
                            >
                                <a
                                    href="#best-practices"
                                    @class([
                                        'group relative flex w-full items-center',      // Layout
                                        'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                        'text-sm',                                       // Typography
                                        'text-gray-600 dark:text-gray-400',                                    // Colors
                                        'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                        'data-[state=open]:text-gray-900 dark:data-[state=open]:text-gray-100',            // State Colors
                                        'focus:outline-none focus-visible:outline-none', // Focus Reset
                                        'focus-visible:before:ring-primary',             // Focus Styles
                                        'transition-colors',                             // Transitions
                                        'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                        'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                        'hover:before:bg-gray-100/50 dark:hover:before:bg-gray-800/50',                   // Pseudo Before Hover
                                        'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                        'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                        'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                        'after:transition-colors',                       // Pseudo After Transitions
                                    ])
                                >
                                    <span
                                        @class([
                                            'truncate', // Text Overflow
                                        ])
                                    >
                                        Best Practices
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</aside>

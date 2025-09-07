<x-filament-panels::page>
    <div
        @class([
            'mx-auto',           // Spacing
            'w-full max-w-7xl',  // Sizing
        ])
    >
        <!-- Mobile Navigation Dropdown -->
        <div
            @class([
                'block lg:hidden',   // Display only on md and below
                'mb-6',              // Spacing
            ])
        >
            <el-select
                id="mobile-nav"
                name="mobile-nav"
                @class([
                    'w-full',  // Sizing
                ])
            >
                <button
                    type="button"
                    @class([
                        'grid w-full cursor-default grid-cols-1',  // Layout
                        'rounded-md',                               // Border Radius
                        'bg-white dark:bg-white/5',                // Background Colors
                        'py-1.5 pr-2 pl-3',                        // Spacing
                        'text-left text-gray-900 dark:text-white', // Text Alignment & Colors
                        'sm:text-sm/6',                             // Typography
                        'outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10', // Outline
                        'focus-visible:outline-2 focus-visible:-outline-offset-2', // Focus Outline
                        'focus-visible:outline-primary-600 dark:focus-visible:outline-primary-500', // Focus Colors
                    ])
                >
                    <el-selectedcontent
                        @class([
                            'col-start-1 row-start-1',  // Grid Position
                            'truncate pr-6',             // Text Overflow & Spacing
                        ])
                    >
                        Select a section...
                    </el-selectedcontent>
                    <svg
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        data-slot="icon"
                        aria-hidden="true"
                        @class([
                            'col-start-1 row-start-1',               // Grid Position
                            'size-5 sm:size-4',                       // Sizing
                            'self-center justify-self-end',          // Alignment
                            'text-gray-500 dark:text-gray-400',      // Colors
                        ])
                    >
                        <path
                            d="M5.22 10.22a.75.75 0 0 1 1.06 0L8 11.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-2.25 2.25a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 0 1 0-1.06ZM10.78 5.78a.75.75 0 0 1-1.06 0L8 4.06 6.28 5.78a.75.75 0 0 1-1.06-1.06l2.25-2.25a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1 0 1.06Z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                        />
                    </svg>
                </button>

                <el-options
                    anchor="bottom start"
                    popover
                    @class([
                        'w-(--button-width)',                     // Sizing
                        'max-h-60',                                // Max Height
                        'overflow-auto',                           // Overflow
                        'rounded-md',                              // Border Radius
                        'bg-white dark:bg-gray-800',              // Background Colors
                        'py-1',                                    // Spacing
                        'text-base sm:text-sm',                   // Typography
                        'shadow-lg dark:shadow-none',             // Shadow
                        'outline-1 outline-black/5',              // Outline
                        'dark:-outline-offset-1 dark:outline-white/10', // Dark Mode Outline
                        '[--anchor-gap:--spacing(1)]',            // CSS Variables
                        'data-leave:transition data-leave:transition-discrete', // Transitions
                        'data-leave:duration-100 data-leave:ease-in', // Transition Properties
                        'data-closed:data-leave:opacity-0',       // State Transitions
                    ])
                >
                    <!-- Getting Started Group Header -->
                    <el-option
                        disabled
                        @class([
                            'relative block',                         // Layout
                            'cursor-not-allowed',                     // Cursor
                            'py-2 pr-9 pl-3',                        // Spacing
                            'text-gray-900 dark:text-white',         // Colors
                            'opacity-100',                            // Opacity
                            'select-none',                            // Selection
                        ])
                    >
                        <span
                            @class([
                                'block truncate',  // Display & Text Overflow
                                'font-bold',       // Typography
                            ])
                        >
                            Getting Started
                        </span>
                    </el-option>

                    <!-- Getting Started Section Items -->
                    <el-option
                        value="#introduction"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-8',                              // Spacing
                            'text-gray-900 dark:text-white',               // Colors
                            'select-none',                                 // Selection
                            'focus:bg-primary-600 dark:focus:bg-primary-500', // Focus Background
                            'focus:text-white',                            // Focus Text Color
                            'focus:outline-hidden',                        // Focus Outline
                        ])
                    >
                        <span
                            @class([
                                'block truncate',                                  // Display & Text Overflow
                                'font-normal group-aria-selected/option:font-semibold', // Typography
                            ])
                        >
                            Introduction
                        </span>
                    </el-option>
                    <el-option
                        value="#getting-started"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-8',                              // Spacing
                            'text-gray-900 dark:text-white',               // Colors
                            'select-none',                                 // Selection
                            'focus:bg-primary-600 dark:focus:bg-primary-500', // Focus Background
                            'focus:text-white',                            // Focus Text Color
                            'focus:outline-hidden',                        // Focus Outline
                        ])
                    >
                        <span
                            @class([
                                'block truncate',                                  // Display & Text Overflow
                                'font-normal group-aria-selected/option:font-semibold', // Typography
                            ])
                        >
                            Installation
                        </span>
                    </el-option>
                    <el-option
                        value="#development-workflow"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-8',                              // Spacing
                            'text-gray-900 dark:text-white',               // Colors
                            'select-none',                                 // Selection
                            'focus:bg-primary-600 dark:focus:bg-primary-500', // Focus Background
                            'focus:text-white',                            // Focus Text Color
                            'focus:outline-hidden',                        // Focus Outline
                        ])
                    >
                        <span
                            @class([
                                'block truncate',                                  // Display & Text Overflow
                                'font-normal group-aria-selected/option:font-semibold', // Typography
                            ])
                        >
                            Development
                        </span>
                    </el-option>

                    <!-- Architecture Group Header -->
                    <el-option
                        disabled
                        @class([
                            'relative block',                         // Layout
                            'cursor-not-allowed',                     // Cursor
                            'py-2 pr-9 pl-3',                        // Spacing
                            'text-gray-900 dark:text-white',         // Colors
                            'opacity-100',                            // Opacity
                            'select-none',                            // Selection
                        ])
                    >
                        <span
                            @class([
                                'block truncate',  // Display & Text Overflow
                                'font-bold',       // Typography
                            ])
                        >
                            Architecture
                        </span>
                    </el-option>

                    <!-- Architecture Section Items -->
                    <el-option
                        value="#technology-stack"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-8',                              // Spacing
                            'text-gray-900 dark:text-white',               // Colors
                            'select-none',                                 // Selection
                            'focus:bg-primary-600 dark:focus:bg-primary-500', // Focus Background
                            'focus:text-white',                            // Focus Text Color
                            'focus:outline-hidden',                        // Focus Outline
                        ])
                    >
                        <span
                            @class([
                                'block truncate',                                  // Display & Text Overflow
                                'font-normal group-aria-selected/option:font-semibold', // Typography
                            ])
                        >
                            Technology Stack
                        </span>
                    </el-option>
                    <el-option
                        value="#module-architecture"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-8',                              // Spacing
                            'text-gray-900 dark:text-white',               // Colors
                            'select-none',                                 // Selection
                            'focus:bg-primary-600 dark:focus:bg-primary-500', // Focus Background
                            'focus:text-white',                            // Focus Text Color
                            'focus:outline-hidden',                        // Focus Outline
                        ])
                    >
                        <span
                            @class([
                                'block truncate',                                  // Display & Text Overflow
                                'font-normal group-aria-selected/option:font-semibold', // Typography
                            ])
                        >
                            Module System
                        </span>
                    </el-option>
                    <el-option
                        value="#best-practices"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-8',                              // Spacing
                            'text-gray-900 dark:text-white',               // Colors
                            'select-none',                                 // Selection
                            'focus:bg-primary-600 dark:focus:bg-primary-500', // Focus Background
                            'focus:text-white',                            // Focus Text Color
                            'focus:outline-hidden',                        // Focus Outline
                        ])
                    >
                        <span
                            @class([
                                'block truncate',                                  // Display & Text Overflow
                                'font-normal group-aria-selected/option:font-semibold', // Typography
                            ])
                        >
                            Best Practices
                        </span>
                    </el-option>
                </el-options>
            </el-select>
        </div>
        <div
            @class([
                'flex flex-col lg:flex-row', // Layout & Direction
                'lg:gap-10',                 // Spacing
            ])
        >
            <!-- Left Sidebar - Navigation -->
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
                <div
                    @class([
                        'relative',  // Positioning
                    ])
                >
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

            <!-- Main Content Area -->
            <div
                @class([
                    'flex-1', // Flex Properties
                ])
            >
                <!-- Article Content -->
                <div>
                    <!-- Main Content -->
                    <div>
                        <div
                            @class([
                                'prose prose-lg prose-neutral', // Typography Styles
                                'dark:prose-invert',             // Dark Mode
                                'max-w-none',                   // Sizing
                            ])
                        >
                            {!! str($post->content)->markdown()->toHtmlString() !!}
                        </div>

                        <!-- Navigation Footer -->
                        <div
                            data-orientation="horizontal"
                            role="separator"
                            @class([
                                'align-center flex w-full flex-row', // Layout
                                'items-center',                      // Alignment
                                'text-center',                       // Text Alignment
                            ])
                        >
                            <div
                                @class([
                                    'w-full',           // Sizing
                                    'border-t',         // Borders
                                    'border-solid',     // Border Style
                                    'border-gray-200 dark:border-gray-700',   // Border Colors
                                ])
                            ></div>
                        </div>

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
                                    Learn how to set up and start using the
                                    Venture Starter Kit.
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileNavSelect = document.getElementById('mobile-nav')

            if (mobileNavSelect) {
                mobileNavSelect.addEventListener('change', function (event) {
                    const selectedValue = event.target.value

                    if (selectedValue) {
                        // Navigate to the selected section
                        const targetElement =
                            document.querySelector(selectedValue)

                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start',
                            })
                        } else {
                            // Fallback to changing the hash
                            window.location.hash = selectedValue
                        }
                    }
                })
            }
        })
    </script>
</x-filament-panels::page>

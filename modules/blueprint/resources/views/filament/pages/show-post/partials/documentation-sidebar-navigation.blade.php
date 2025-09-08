<aside
    @class([
        'hidden lg:block',                              // Display & Visibility
        'overflow-y-auto',                               // Overflow
        'lg:sticky lg:top-20',                          // Positioning
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
                    '-mx-2.5',   // Spacing
                ])
            >
                @foreach ($this->navigationItems as $item)
                    @if ($item['type'] === 'post')
                        {{-- Standalone post --}}
                        <li>
                            <a
                                wire:navigate.hover
                                href="{{ $item['post']->getUrl() }}"
                                @class([
                                    'group relative flex w-full items-center',      // Layout
                                    'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                    'text-sm font-medium',                           // Typography
                                    'text-gray-600 dark:text-gray-400',                                    // Colors
                                    'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                    'data-[state=active]:text-primary-600 dark:data-[state=active]:text-primary-400', // Active Colors
                                    'focus:outline-none focus-visible:outline-none', // Focus Reset
                                    'focus-visible:before:ring-primary',             // Focus Styles
                                    'transition-colors',                             // Transitions
                                    'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                    'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                    'hover:before:bg-gray-200/50 dark:hover:before:bg-gray-700/50',                   // Pseudo Before Hover
                                    'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                ])
                                {{ $post->slug === $item['post']->slug ? 'data-state=active' : '' }}
                            >
                                <span
                                    @class([
                                        'truncate', // Text Overflow
                                    ])
                                >
                                    {{ $item['post']->title }}
                                </span>
                            </a>
                        </li>
                    @else
                        {{-- Navigation group with accordion --}}
                        <li
                            x-data="{ open: true }"
                            @class([
                                'flex flex-col',              // Layout
                                'data-[state=open]:mb-1.5',  // Conditional Spacing
                            ])
                            :data-state="open ? 'open' : 'closed'"
                            data-orientation="vertical"
                        >
                            <button
                                @click="open = !open"
                                type="button"
                                :aria-expanded="open.toString()"
                                :data-state="open ? 'open' : 'closed'"
                                @class([
                                    'group relative flex w-full items-center justify-between', // Layout
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
                                    'hover:before:bg-gray-200/50 dark:hover:before:bg-gray-700/50',              // Pseudo-element Hover
                                    'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo-element Focus
                                ])
                            >
                                <span
                                    @class([
                                        'truncate', // Text Overflow
                                    ])
                                >
                                    {{ $item['name'] }}
                                </span>
                                @svg('lucide-chevron-up', implode(' ', [
                                    'h-4 w-4',                                      // Size
                                    'shrink-0',                                     // Flex Properties
                                    'transition-transform duration-200',           // Transitions
                                    'text-gray-600 dark:text-gray-400',           // Colors
                                    'group-hover:text-gray-900 dark:group-hover:text-gray-100', // Hover Colors
                                    'group-data-[state=open]:text-gray-900 dark:group-data-[state=open]:text-gray-100', // State Colors
                                ]), [
                                    ':class' => "{ 'rotate-180': open }",
                                ])
                            </button>

                            <div
                                x-show="open"
                                x-collapse.duration.200ms
                                role="region"
                                data-orientation="vertical"
                                :data-state="open ? 'open' : 'closed'"
                                @class([
                                    'overflow-hidden',    // Overflow
                                    'focus:outline-none', // Focus Styles
                                ])
                            >
                                <ul
                                    @class([
                                        'ms-5',             // Spacing
                                        'border-s',         // Borders
                                        'border-gray-200 dark:border-gray-700',   // Border Colors
                                    ])
                                >
                                    @foreach ($item['posts'] as $groupPost)
                                        <li
                                            @class([
                                                '-ms-px ps-1.5', // Spacing
                                            ])
                                        >
                                            <a
                                                wire:navigate.hover
                                                href="{{ $groupPost->getUrl() }}"
                                                @class([
                                                    'group relative flex w-full items-center',      // Layout
                                                    'gap-1.5 px-2.5 py-1.5',                        // Spacing
                                                    'text-sm font-medium',                           // Typography
                                                    'text-gray-600 dark:text-gray-400',                                    // Colors
                                                    'hover:text-gray-900 dark:hover:text-gray-100',                        // Hover Colors
                                                    'data-[state=active]:text-primary-600 dark:data-[state=active]:text-primary-400', // Active Colors
                                                    'focus:outline-none focus-visible:outline-none', // Focus Reset
                                                    'focus-visible:before:ring-primary',             // Focus Styles
                                                    'transition-colors',                             // Transitions
                                                    'before:absolute before:inset-x-0 before:inset-y-px before:z-[-1]', // Pseudo Before Position
                                                    'before:rounded-md before:transition-colors',   // Pseudo Before Styles
                                                    'hover:before:bg-gray-200/50 dark:hover:before:bg-gray-700/50',                   // Pseudo Before Hover
                                                    'focus-visible:before:ring-2 focus-visible:before:ring-inset', // Pseudo Before Focus
                                                    'after:absolute after:inset-y-0.5 after:-left-1.5', // Pseudo After Position
                                                    'after:block after:w-px after:rounded-full',    // Pseudo After Shape
                                                    'after:transition-colors',                       // Pseudo After Transitions
                                                    'data-[state=active]:after:bg-primary-600 dark:data-[state=active]:after:bg-primary-400', // Pseudo After Active
                                                ])
                                                {{ $post->slug === $groupPost->slug ? 'data-state=active' : '' }}
                                            >
                                                <span
                                                    @class([
                                                        'truncate', // Text Overflow
                                                    ])
                                                >
                                                    {{ $groupPost->title }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

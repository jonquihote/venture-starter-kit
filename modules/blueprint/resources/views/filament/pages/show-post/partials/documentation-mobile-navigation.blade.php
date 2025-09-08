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
        value="{{ $this->post->getUrl() }}"
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
                {{ $this->post->title }}
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
            @foreach ($this->navigationItems as $item)
                @if ($item['type'] === 'post')
                    {{-- Standalone post option --}}
                    <el-option
                        value="{{ $item['post']->getUrl() }}"
                        @class([
                            'group/option relative block cursor-default',  // Layout & Group
                            'py-2 pr-9 pl-3',                              // Spacing
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
                            {{ $item['post']->title }}
                        </span>
                    </el-option>
                @else
                    {{-- Group header --}}
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
                            {{ $item['name'] }}
                        </span>
                    </el-option>

                    {{-- Group posts --}}
                    @foreach ($item['posts'] as $groupPost)
                        <el-option
                            value="{{ $groupPost->getUrl() }}"
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
                                {{ $groupPost->title }}
                            </span>
                        </el-option>
                    @endforeach
                @endif
            @endforeach
        </el-options>
    </el-select>
</div>

@push('show-post-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileNavSelect = document.getElementById('mobile-nav')

            if (mobileNavSelect) {
                mobileNavSelect.addEventListener('change', function (event) {
                    const selectedValue = event.target.value

                    if (selectedValue) {
                        // Navigate to the selected URL
                        window.location.href = selectedValue
                    }
                })
            }
        })
    </script>
@endpush

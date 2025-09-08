<x-filament-panels::page>
    <div
        @class([
            'mx-auto',           // Spacing
            'w-full max-w-7xl',  // Sizing
        ])
    >
        @include('blueprint::filament.pages.show-post.partials.documentation-mobile-navigation')

        @if($post->hasEditAccess())
            <div class="flex justify-end mb-4">
                <x-filament::link
                    :href="$post->getEditUrl()"
                    icon="lucide-square-pen"
                    color="gray"
                    size="sm"
                >
                    {{ __('blueprint::filament/pages/show-post.actions.edit.label') }}
                </x-filament::link>
            </div>
        @endif

        <div
            @class([
                'flex flex-col lg:flex-row', // Layout & Direction
                'lg:gap-10',                 // Spacing
            ])
        >
            @include('blueprint::filament.pages.show-post.partials.documentation-sidebar-navigation')

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
                                'prose prose-neutral', // Typography Styles
                                'dark:prose-invert',             // Dark Mode
                                'max-w-none',                   // Sizing
                                'mb-12',                   // Spacing
                            ])
                        >
                            <x-markdown theme="material-theme-palenight">
                                {{ $post->content }}
                            </x-markdown>
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

                        @include('blueprint::filament.pages.show-post.partials.documentation-footer-navigation')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('show-post-scripts')
</x-filament-panels::page>

<x-filament-panels::page>
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:grid lg:grid-cols-10 lg:gap-10">
            <!-- Left Sidebar - Navigation -->
            <aside
                class="hidden overflow-y-auto py-8 lg:sticky lg:top-16 lg:col-span-2 lg:-ms-4 lg:block lg:max-h-[calc(100vh-4rem)] lg:pe-6 lg:ps-4"
            >
                <div class="relative">
                    <nav>
                        <ul class="isolate -mx-2.5 -mt-1.5">
                            <li
                                data-state="open"
                                data-orientation="vertical"
                                class="flex flex-col data-[state=open]:mb-1.5"
                            >
                                <button
                                    type="button"
                                    aria-expanded="true"
                                    data-state="open"
                                    class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:ring-primary focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm font-semibold transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                >
                                    <span class="truncate">
                                        Getting Started
                                    </span>
                                    <span
                                        class="ms-auto inline-flex items-center gap-1.5"
                                    >
                                        <x-filament::icon
                                            icon="heroicon-s-chevron-down"
                                            class="size-5 shrink-0 transform transition-transform duration-200 group-data-[state=open]:rotate-180"
                                        />
                                    </span>
                                </button>
                                <div
                                    role="region"
                                    data-orientation="vertical"
                                    class="overflow-hidden focus:outline-none data-[state=closed]:animate-[accordion-up_200ms_ease-out] data-[state=open]:animate-[accordion-down_200ms_ease-out]"
                                    data-state="open"
                                >
                                    <ul class="border-default ms-5 border-s">
                                        <li class="-ms-px ps-1.5">
                                            <a
                                                href="#introduction"
                                                class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=active]:text-primary text-muted focus-visible:before:ring-primary data-[state=active]:after:bg-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors after:absolute after:inset-y-0.5 after:-left-1.5 after:block after:w-px after:rounded-full after:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                            >
                                                <x-filament::icon
                                                    icon="heroicon-s-home"
                                                    class="text-primary group-data-[state=open]:text-primary size-5 shrink-0"
                                                />
                                                <span class="truncate">
                                                    Introduction
                                                </span>
                                            </a>
                                        </li>
                                        <li class="-ms-px ps-1.5">
                                            <a
                                                href="#getting-started"
                                                class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors after:absolute after:inset-y-0.5 after:-left-1.5 after:block after:w-px after:rounded-full after:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                            >
                                                <x-filament::icon
                                                    icon="heroicon-s-rocket-launch"
                                                    class="text-dimmed group-hover:text-default group-data-[state=open]:text-default size-5 shrink-0 transition-colors"
                                                />
                                                <span class="truncate">
                                                    Installation
                                                </span>
                                            </a>
                                        </li>
                                        <li class="-ms-px ps-1.5">
                                            <a
                                                href="#development-workflow"
                                                class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors after:absolute after:inset-y-0.5 after:-left-1.5 after:block after:w-px after:rounded-full after:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                            >
                                                <x-filament::icon
                                                    icon="heroicon-s-cog-6-tooth"
                                                    class="text-dimmed group-hover:text-default group-data-[state=open]:text-default size-5 shrink-0 transition-colors"
                                                />
                                                <span class="truncate">
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
                                class="flex flex-col data-[state=open]:mb-1.5"
                            >
                                <button
                                    type="button"
                                    aria-expanded="true"
                                    data-state="open"
                                    class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:ring-primary focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm font-semibold transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                >
                                    <span class="truncate">Architecture</span>
                                    <span
                                        class="ms-auto inline-flex items-center gap-1.5"
                                    >
                                        <x-filament::icon
                                            icon="heroicon-s-chevron-down"
                                            class="size-5 shrink-0 transform transition-transform duration-200 group-data-[state=open]:rotate-180"
                                        />
                                    </span>
                                </button>
                                <div
                                    role="region"
                                    data-orientation="vertical"
                                    class="overflow-hidden focus:outline-none data-[state=closed]:animate-[accordion-up_200ms_ease-out] data-[state=open]:animate-[accordion-down_200ms_ease-out]"
                                    data-state="open"
                                >
                                    <ul class="border-default ms-5 border-s">
                                        <li class="-ms-px ps-1.5">
                                            <a
                                                href="#technology-stack"
                                                class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors after:absolute after:inset-y-0.5 after:-left-1.5 after:block after:w-px after:rounded-full after:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                            >
                                                <x-filament::icon
                                                    icon="heroicon-s-cube"
                                                    class="text-dimmed group-hover:text-default group-data-[state=open]:text-default size-5 shrink-0 transition-colors"
                                                />
                                                <span class="truncate">
                                                    Technology Stack
                                                </span>
                                            </a>
                                        </li>
                                        <li class="-ms-px ps-1.5">
                                            <a
                                                href="#module-architecture"
                                                class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors after:absolute after:inset-y-0.5 after:-left-1.5 after:block after:w-px after:rounded-full after:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                            >
                                                <x-filament::icon
                                                    icon="heroicon-s-squares-2x2"
                                                    class="text-dimmed group-hover:text-default group-data-[state=open]:text-default size-5 shrink-0 transition-colors"
                                                />
                                                <span class="truncate">
                                                    Module System
                                                </span>
                                            </a>
                                        </li>
                                        <li class="-ms-px ps-1.5">
                                            <a
                                                href="#best-practices"
                                                class="hover:text-highlighted hover:before:bg-elevated/50 data-[state=open]:text-highlighted text-muted focus-visible:before:ring-primary group relative flex w-full items-center gap-1.5 px-2.5 py-1.5 text-sm transition-colors before:absolute before:inset-x-0 before:inset-y-px before:z-[-1] before:rounded-md before:transition-colors after:absolute after:inset-y-0.5 after:-left-1.5 after:block after:w-px after:rounded-full after:transition-colors focus:outline-none focus-visible:outline-none focus-visible:before:ring-2 focus-visible:before:ring-inset"
                                            >
                                                <x-filament::icon
                                                    icon="heroicon-s-star"
                                                    class="text-dimmed group-hover:text-default group-data-[state=open]:text-default size-5 shrink-0 transition-colors"
                                                />
                                                <span class="truncate">
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
            <div class="lg:col-span-8">
                <div class="flex flex-col lg:grid lg:grid-cols-10 lg:gap-10">
                    <!-- Article Content -->
                    <div class="lg:col-span-8">
                        <!-- Enhanced Header -->
                        <div class="border-default relative border-b py-8">
                            <!-- Search and Actions Bar -->
                            <div
                                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                            >
                                <div class="flex items-center gap-3">
                                    <!-- Search Button -->
                                    <button
                                        type="button"
                                        onclick="alert('Search functionality coming soon! Use ⌘K shortcut.')"
                                        class="search-button"
                                    >
                                        <x-filament::icon
                                            icon="heroicon-s-magnifying-glass"
                                            class="h-4 w-4"
                                        />
                                        <span class="flex-1 text-left">
                                            Search documentation...
                                        </span>
                                        <div class="flex items-center gap-1">
                                            <kbd class="search-kbd">⌘</kbd>
                                            <kbd class="search-kbd">K</kbd>
                                        </div>
                                    </button>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Theme Toggle (Placeholder) -->
                                    <button
                                        type="button"
                                        onclick="alert('Theme toggle functionality coming soon!')"
                                        class="rounded-lg border border-gray-200 bg-white p-2 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                                    >
                                        <x-filament::icon
                                            icon="heroicon-s-moon"
                                            class="h-4 w-4 text-gray-600 dark:text-gray-400"
                                        />
                                    </button>

                                    <!-- GitHub Link -->
                                    <a
                                        href="https://github.com/laravel/laravel"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="rounded-lg border border-gray-200 bg-white p-2 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                                    >
                                        <svg
                                            class="h-4 w-4 text-gray-600 dark:text-gray-400"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"
                                            />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Breadcrumb Navigation -->
                            <nav
                                class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400"
                            >
                                <a
                                    href="#"
                                    class="hover:text-gray-700 dark:hover:text-gray-200"
                                >
                                    Venture
                                </a>
                                <x-filament::icon
                                    icon="heroicon-s-chevron-right"
                                    class="h-3 w-3"
                                />
                                <a
                                    href="#"
                                    class="hover:text-gray-700 dark:hover:text-gray-200"
                                >
                                    Documentation
                                </a>
                                <x-filament::icon
                                    icon="heroicon-s-chevron-right"
                                    class="h-3 w-3"
                                />
                                <span
                                    class="font-medium text-gray-900 dark:text-gray-100"
                                >
                                    {{ $post->title }}
                                </span>
                            </nav>

                            <!-- Title and Description -->
                            <div
                                class="text-primary mb-2.5 flex items-center gap-1.5 text-sm font-semibold"
                            >
                                Venture Starter Kit
                            </div>
                            <div>
                                <div
                                    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
                                >
                                    <h1
                                        class="text-highlighted text-pretty text-3xl font-bold sm:text-4xl"
                                    >
                                        {{ $post->title }}
                                    </h1>
                                    <div
                                        class="flex flex-wrap items-center gap-1.5"
                                    ></div>
                                </div>
                                <div
                                    class="text-muted mt-4 text-pretty text-lg"
                                >
                                    A comprehensive Laravel 12 application
                                    template for building modern, scalable web
                                    applications.
                                </div>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="mt-8 space-y-12 pb-24">
                            <!-- Module Cards Section -->
                            <div class="not-prose mb-12">
                                <div class="section-separator mb-8"></div>
                                <h2
                                    class="mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-100"
                                >
                                    Core Modules
                                </h2>
                                <div
                                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                                >
                                    <!-- Aeon Module Card -->
                                    <div class="module-card">
                                        <div
                                            class="module-card-icon bg-blue-100 dark:bg-blue-900/30"
                                        >
                                            <x-filament::icon
                                                icon="heroicon-s-cog-8-tooth"
                                                class="h-6 w-6 text-blue-600 dark:text-blue-400"
                                            />
                                        </div>
                                        <div class="module-card-title">
                                            Aeon Module
                                        </div>
                                        <div class="module-card-description">
                                            Core utilities and Laravel package
                                            integration including Horizon,
                                            Pulse, Reverb, Scout, and Telescope.
                                        </div>
                                    </div>

                                    <!-- Alpha Module Card -->
                                    <div class="module-card">
                                        <div
                                            class="module-card-icon bg-purple-100 dark:bg-purple-900/30"
                                        >
                                            <x-filament::icon
                                                icon="heroicon-s-squares-2x2"
                                                class="h-6 w-6 text-purple-600 dark:text-purple-400"
                                            />
                                        </div>
                                        <div class="module-card-title">
                                            Alpha Module
                                        </div>
                                        <div class="module-card-description">
                                            Advanced Filament panel factory with
                                            multi-tenancy support and
                                            comprehensive event system.
                                        </div>
                                    </div>

                                    <!-- Omega Module Card -->
                                    <div class="module-card">
                                        <div
                                            class="module-card-icon bg-green-100 dark:bg-green-900/30"
                                        >
                                            <x-filament::icon
                                                icon="heroicon-s-users"
                                                class="h-6 w-6 text-green-600 dark:text-green-400"
                                            />
                                        </div>
                                        <div class="module-card-title">
                                            Omega Module
                                        </div>
                                        <div class="module-card-description">
                                            Team invitation and membership
                                            system with role-based access
                                            control integration.
                                        </div>
                                    </div>

                                    <!-- Blueprint Module Card -->
                                    <div class="module-card">
                                        <div
                                            class="module-card-icon bg-lime-100 dark:bg-lime-900/30"
                                        >
                                            <x-filament::icon
                                                icon="heroicon-s-book-open"
                                                class="h-6 w-6 text-lime-600 dark:text-lime-400"
                                            />
                                        </div>
                                        <div class="module-card-title">
                                            Blueprint Module
                                        </div>
                                        <div class="module-card-description">
                                            Documentation hub with comprehensive
                                            style guides and development best
                                            practices.
                                        </div>
                                    </div>

                                    <!-- Home Module Card -->
                                    <div class="module-card">
                                        <div
                                            class="module-card-icon bg-orange-100 dark:bg-orange-900/30"
                                        >
                                            <x-filament::icon
                                                icon="heroicon-s-home"
                                                class="h-6 w-6 text-orange-600 dark:text-orange-400"
                                            />
                                        </div>
                                        <div class="module-card-title">
                                            Home Module
                                        </div>
                                        <div class="module-card-description">
                                            Main application dashboard with base
                                            page layouts and primary user
                                            workflows.
                                        </div>
                                    </div>

                                    <!-- Available Slot -->
                                    <div
                                        class="module-card border-dashed bg-gray-50/50 hover:bg-gray-100/50 dark:bg-gray-800/50 dark:hover:bg-gray-700/50"
                                    >
                                        <div
                                            class="module-card-icon bg-gray-100 dark:bg-gray-700"
                                        >
                                            <x-filament::icon
                                                icon="heroicon-s-plus"
                                                class="h-6 w-6 text-gray-400"
                                            />
                                        </div>
                                        <div
                                            class="module-card-title text-gray-500 dark:text-gray-400"
                                        >
                                            Available
                                        </div>
                                        <div
                                            class="module-card-description text-gray-400 dark:text-gray-500"
                                        >
                                            Space for your custom module
                                            implementation and features.
                                        </div>
                                    </div>
                                </div>
                                <div class="section-separator mt-12"></div>
                            </div>

                            <div class="prose-enhanced">
                                {!! str($post->content)->markdown()->toHtmlString() !!}
                            </div>

                            <!-- Navigation Footer -->
                            <div
                                data-orientation="horizontal"
                                role="separator"
                                class="align-center flex w-full flex-row items-center text-center"
                            >
                                <div
                                    class="border-default w-full border-t border-solid"
                                ></div>
                            </div>

                            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                                <span class="hidden lg:block">&nbsp;</span>
                                <a
                                    href="#getting-started"
                                    class="border-default hover:bg-elevated/50 focus-visible:outline-primary group block rounded-lg border px-6 py-8 text-right transition-colors"
                                >
                                    <div
                                        class="bg-elevated ring-accented group-hover:bg-primary/10 group-hover:ring-primary/50 mb-4 inline-flex items-center rounded-full p-1.5 ring transition"
                                    >
                                        <x-filament::icon
                                            icon="heroicon-s-rocket-launch"
                                            class="text-highlighted group-hover:text-primary size-5 shrink-0 transition-[color,translate] group-active:translate-x-0.5"
                                        />
                                    </div>
                                    <p
                                        class="text-highlighted mb-1 truncate text-[15px] font-medium"
                                    >
                                        Getting Started
                                    </p>
                                    <p class="text-muted line-clamp-2 text-sm">
                                        Learn how to set up and start using the
                                        Venture Starter Kit.
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar - Table of Contents -->
                    <nav
                        data-state="closed"
                        class="bg-default/75 sticky top-16 z-10 order-first -mx-4 max-h-[calc(100vh-4rem)] overflow-y-auto px-4 backdrop-blur sm:-mx-6 sm:px-6 lg:order-last lg:col-span-2 lg:bg-[initial]"
                    >
                        <div
                            class="border-default sm:pb-4.5 flex flex-col border-b border-dashed pb-2.5 pt-4 sm:pt-6 lg:border-0 lg:py-8"
                        >
                            <!-- Mobile TOC Toggle -->
                            <button
                                type="button"
                                aria-expanded="false"
                                data-state="closed"
                                class="focus-visible:outline-primary group -mt-1.5 flex flex-1 items-center gap-1.5 py-1.5 text-sm font-semibold lg:hidden"
                            >
                                <span class="truncate">Table of Contents</span>
                                <span
                                    class="ms-auto inline-flex items-center gap-1.5"
                                >
                                    <x-filament::icon
                                        icon="heroicon-s-chevron-down"
                                        class="size-5 shrink-0 transform transition-transform duration-200 group-data-[state=open]:rotate-180 lg:hidden"
                                    />
                                </span>
                            </button>

                            <!-- Desktop TOC Header -->
                            <p
                                class="focus-visible:outline-primary group -mt-1.5 hidden flex-1 items-center gap-1.5 py-1.5 text-sm font-semibold lg:flex"
                            >
                                <span class="truncate">Table of Contents</span>
                            </p>

                            <!-- TOC Links -->
                            <div
                                class="hidden overflow-hidden focus:outline-none lg:flex"
                            >
                                <ul
                                    class="min-w-0 space-y-1"
                                    id="toc-list"
                                >
                                    <li class="min-w-0">
                                        <a
                                            href="#introduction"
                                            class="text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Introduction
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#key-features"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Key Features
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#technology-stack"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Technology Stack
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#module-architecture"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Module Architecture
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#getting-started"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Getting Started
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#development-workflow"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Development Workflow
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#best-practices"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Best Practices
                                            </span>
                                        </a>
                                    </li>
                                    <li class="min-w-0">
                                        <a
                                            href="#configuration"
                                            class="text-muted hover:text-primary focus-visible:outline-primary group relative flex items-center py-1 text-sm"
                                        >
                                            <span class="truncate">
                                                Configuration
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Community Links -->
                            <div class="mt-6 hidden gap-6 lg:flex lg:flex-col">
                                <div class="!mt-6 hidden space-y-6 lg:block">
                                    <div
                                        data-orientation="horizontal"
                                        role="separator"
                                        class="align-center flex w-full flex-row items-center text-center"
                                    >
                                        <div
                                            class="border-default w-full border-t border-dashed"
                                        ></div>
                                    </div>
                                    <nav class="flex flex-col gap-3">
                                        <p
                                            class="flex items-center gap-1.5 text-sm font-semibold"
                                        >
                                            Resources
                                        </p>
                                        <ul class="flex flex-col gap-2">
                                            <li class="relative">
                                                <a
                                                    href="https://laravel.com/docs"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="hover:text-default text-muted focus-visible:outline-primary group flex items-center gap-1.5 text-sm transition-colors"
                                                >
                                                    <x-filament::icon
                                                        icon="heroicon-s-book-open"
                                                        class="size-5 shrink-0"
                                                    />
                                                    <span class="truncate">
                                                        Laravel Documentation
                                                        <x-filament::icon
                                                            icon="heroicon-s-arrow-top-right-on-square"
                                                            class="text-dimmed absolute top-0 size-3"
                                                        />
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="relative">
                                                <a
                                                    href="https://filamentphp.com/docs"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="hover:text-default text-muted focus-visible:outline-primary group flex items-center gap-1.5 text-sm transition-colors"
                                                >
                                                    <x-filament::icon
                                                        icon="heroicon-s-squares-2x2"
                                                        class="size-5 shrink-0"
                                                    />
                                                    <span class="truncate">
                                                        Filament Documentation
                                                        <x-filament::icon
                                                            icon="heroicon-s-arrow-top-right-on-square"
                                                            class="text-dimmed absolute top-0 size-3"
                                                        />
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="relative">
                                                <a
                                                    href="https://vuejs.org/guide/"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="hover:text-default text-muted focus-visible:outline-primary group flex items-center gap-1.5 text-sm transition-colors"
                                                >
                                                    <x-filament::icon
                                                        icon="heroicon-s-code-bracket"
                                                        class="size-5 shrink-0"
                                                    />
                                                    <span class="truncate">
                                                        Vue 3 Guide
                                                        <x-filament::icon
                                                            icon="heroicon-s-arrow-top-right-on-square"
                                                            class="text-dimmed absolute top-0 size-3"
                                                        />
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="relative">
                                                <a
                                                    href="https://pestphp.com/docs/"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="hover:text-default text-muted focus-visible:outline-primary group flex items-center gap-1.5 text-sm transition-colors"
                                                >
                                                    <x-filament::icon
                                                        icon="heroicon-s-beaker"
                                                        class="size-5 shrink-0"
                                                    />
                                                    <span class="truncate">
                                                        Pest Testing
                                                        <x-filament::icon
                                                            icon="heroicon-s-arrow-top-right-on-square"
                                                            class="text-dimmed absolute top-0 size-3"
                                                        />
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced custom styling -->
    <style>
        /* Additional custom overrides for enhanced prose */
        .prose-enhanced blockquote {
            @apply border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 px-6 py-4 my-6 rounded-r-lg;
        }

        .prose-enhanced blockquote p {
            @apply mb-0 text-blue-900 dark:text-blue-100;
        }

        .prose-enhanced pre {
            @apply relative;
        }

        /* Custom styling for technology stack tables */
        .prose-enhanced tbody tr:nth-child(even) {
            @apply bg-gray-50/50 dark:bg-gray-800/50;
        }

        /* Smooth transitions for interactive elements */
        .prose-enhanced a {
            @apply transition-colors duration-200;
        }

        /* Enhanced list styling */
        .prose-enhanced li {
            @apply mb-1;
        }

        .prose-enhanced li::marker {
            @apply text-blue-500 dark:text-blue-400;
        }
    </style>

    <!-- Professional Footer -->
    <footer
        class="mt-16 border-t border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900"
    >
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <!-- Brand Section -->
                <div class="md:col-span-1">
                    <div class="mb-4 flex items-center gap-2">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-600"
                        >
                            <span class="text-sm font-bold text-white">V</span>
                        </div>
                        <span
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                        >
                            Venture
                        </span>
                    </div>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        A comprehensive Laravel 12 starter kit for building
                        modern web applications.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3
                        class="mb-4 text-sm font-semibold text-gray-900 dark:text-gray-100"
                    >
                        Quick Links
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="#getting-started"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Getting Started
                            </a>
                        </li>
                        <li>
                            <a
                                href="#technology-stack"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Technology Stack
                            </a>
                        </li>
                        <li>
                            <a
                                href="#module-architecture"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Architecture
                            </a>
                        </li>
                        <li>
                            <a
                                href="#best-practices"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Best Practices
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3
                        class="mb-4 text-sm font-semibold text-gray-900 dark:text-gray-100"
                    >
                        Resources
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="https://laravel.com/docs"
                                target="_blank"
                                class="flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Laravel Docs
                                <x-filament::icon
                                    icon="heroicon-s-arrow-top-right-on-square"
                                    class="h-3 w-3"
                                />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://filamentphp.com/docs"
                                target="_blank"
                                class="flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Filament Docs
                                <x-filament::icon
                                    icon="heroicon-s-arrow-top-right-on-square"
                                    class="h-3 w-3"
                                />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://vuejs.org/guide/"
                                target="_blank"
                                class="flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Vue 3 Guide
                                <x-filament::icon
                                    icon="heroicon-s-arrow-top-right-on-square"
                                    class="h-3 w-3"
                                />
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://pestphp.com/docs/"
                                target="_blank"
                                class="flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Pest Testing
                                <x-filament::icon
                                    icon="heroicon-s-arrow-top-right-on-square"
                                    class="h-3 w-3"
                                />
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h3
                        class="mb-4 text-sm font-semibold text-gray-900 dark:text-gray-100"
                    >
                        Connect
                    </h3>
                    <div class="flex items-center gap-4">
                        <a
                            href="https://github.com/laravel/laravel"
                            target="_blank"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"
                                />
                            </svg>
                        </a>
                        <a
                            href="https://twitter.com/laravelphp"
                            target="_blank"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div
                class="mt-8 flex flex-col items-center justify-between border-t border-gray-200 pt-8 md:flex-row dark:border-gray-700"
            >
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} Venture Starter Kit. Built with Laravel
                    & Filament.
                </div>
                <div
                    class="mt-4 text-sm text-gray-500 md:mt-0 dark:text-gray-400"
                >
                    Made with ❤️ for the Laravel community
                </div>
            </div>
        </div>
    </footer>

    <!-- Enhanced JavaScript functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Enhanced smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault()
                    const target = document.querySelector(
                        this.getAttribute('href'),
                    )
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                        })

                        // Update URL without triggering scroll
                        history.pushState(null, null, this.getAttribute('href'))
                    }
                })
            })

            // Keyboard shortcuts
            document.addEventListener('keydown', function (e) {
                // Command/Ctrl + K for search
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault()
                    alert(
                        'Search functionality coming soon! This would open the search modal.',
                    )
                }
            })

            // Enhanced TOC scroll spy with smooth transitions
            const observerOptions = {
                rootMargin: '-20% 0% -70% 0%',
                threshold: 0.1,
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    const id = entry.target.getAttribute('id')
                    const tocLink = document.querySelector(
                        `#toc-list a[href="#${id}"]`,
                    )
                    if (tocLink) {
                        if (entry.isIntersecting) {
                            // Remove active class from all TOC links
                            document
                                .querySelectorAll('#toc-list a')
                                .forEach((link) => {
                                    link.classList.remove('text-primary')
                                    link.classList.add('text-muted')
                                })
                            // Add active class to current link
                            tocLink.classList.remove('text-muted')
                            tocLink.classList.add('text-primary')

                            // Add subtle animation
                            tocLink.style.transform = 'translateX(4px)'
                            setTimeout(() => {
                                if (
                                    tocLink.classList.contains('text-primary')
                                ) {
                                    tocLink.style.transform = 'translateX(0)'
                                }
                            }, 150)
                        }
                    }
                })
            }, observerOptions)

            // Observe all headings
            document.querySelectorAll('h2[id], h3[id]').forEach((heading) => {
                observer.observe(heading)
            })

            // Module card hover effects
            document.querySelectorAll('.module-card').forEach((card) => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)'
                })

                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)'
                })
            })

            // Initialize reading progress (optional)
            const progressBar = document.createElement('div')
            progressBar.className =
                'fixed top-0 left-0 w-full h-1 bg-blue-500 dark:bg-blue-400 z-50 transform origin-left scale-x-0 transition-transform duration-150'
            document.body.appendChild(progressBar)

            window.addEventListener('scroll', function () {
                const winScroll =
                    document.body.scrollTop ||
                    document.documentElement.scrollTop
                const height =
                    document.documentElement.scrollHeight -
                    document.documentElement.clientHeight
                const scrolled = winScroll / height
                progressBar.style.transform = `scaleX(${scrolled})`
            })
        })
    </script>
</x-filament-panels::page>

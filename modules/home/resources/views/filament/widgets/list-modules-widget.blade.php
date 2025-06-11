<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-8 gap-8">
            @foreach ($dashboards as $dashboard)
                <a
                    href="{{ $dashboard->link }}"
                    @class(['group', 'fi-panel-' . $dashboard->slug])
                >
                    <div @class([
                        'flex items-center justify-center aspect-square',
                        'bg-primary-600/90 text-white',
                        'rounded shadow-lg',
                        'group-hover:-translate-y-0.5',
                        'group-hover:shadow-2xl',
                        'group-hover:bg-primary-600',
                        'transition',
                    ])>
                        @svg($dashboard->icon, 'w-10 h-10')
                    </div>
                    <span
                        class="block text-xs uppercase font-medium text-center mt-2"
                    >
                        {{ $dashboard->name }}
                    </span>
                </a>
            @endforeach

            @for ($i = 1; $i <= 8; $i++)
                <div class="border aspect-square">
                </div>
            @endfor
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

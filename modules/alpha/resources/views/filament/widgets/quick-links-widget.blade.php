<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-3 gap-2">
            @foreach ($links as $link)
                <x-filament::button
                    :href="$link['url']"
                    :color="$link['color']"
                    target="_blank"
                    tag="a"
                >
                    {{ $link['name'] }}
                </x-filament::button>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

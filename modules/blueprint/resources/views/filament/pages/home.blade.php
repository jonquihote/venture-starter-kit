<x-filament-panels::page>
    {{ str($post->content)->markdown()->toHtmlString() }}
</x-filament-panels::page>

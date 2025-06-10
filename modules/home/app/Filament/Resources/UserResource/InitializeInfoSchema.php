<?php

namespace Venture\Home\Filament\Resources\UserResource;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Lorisleiva\Actions\Action;

class InitializeInfoSchema extends Action
{
    protected string $langPre = 'home::filament/resources/user/info';

    protected function getInfoList(): array
    {
        return [
            TextEntry::make('name')
                ->label("{$this->langPre}.lists.name.label")
                ->translateLabel(),

            TextEntry::make('email')
                ->label("{$this->langPre}.lists.email.label")
                ->translateLabel(),
        ];
    }

    public function handle(Infolist $list): Infolist
    {
        return $list->schema([
            Section::make()->schema($this->getInfoList()),
        ]);
    }
}

<?php

namespace Venture\Home\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use UnitEnum;
use Venture\Home\Enums\Auth\Permissions\PagePermissionsEnum;
use Venture\Home\Enums\NavigationGroupsEnum;
use Venture\Home\Models\Team;
use Venture\Home\Settings\TenancySettings;

class ManageTenancySettings extends SettingsPage
{
    protected static string $settings = TenancySettings::class;

    protected static ?string $slug = 'settings/manage/tenancy';

    protected static string | UnitEnum | null $navigationGroup = NavigationGroupsEnum::Settings;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        Toggle::make('is_single_team_mode')
                            ->label(__('home::filament/pages/settings/tenancy.form.fields.is_single_team_mode.label')),

                        Select::make('default_team_id')
                            ->label(__('home::filament/pages/settings/tenancy.form.fields.default_team_id.label'))
                            ->options(Team::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->visibleJs(<<<'JS'
                                $get('is_single_team_mode') == true
                            JS),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['default_team_id'] = $data['is_single_team_mode'] === true
            ? $data['default_team_id']
            : null;

        return $data;
    }

    public static function canAccess(): bool
    {
        return Auth::user()->can(PagePermissionsEnum::ManageTenancySettings);
    }

    public static function getNavigationLabel(): string
    {
        return __('home::filament/pages/settings/tenancy.navigation.label');
    }

    public function getTitle(): string
    {
        return __('home::filament/pages/settings/tenancy.title');
    }
}

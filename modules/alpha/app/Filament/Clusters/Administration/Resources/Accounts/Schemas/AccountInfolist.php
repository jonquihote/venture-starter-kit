<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Aeon\Packages\Spatie\Permission\Models\Role;

class AccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('alpha::filament/resources/account/infolist.entries.name.label'))
                            ->columnSpanFull(),

                        TextEntry::make('username.value')
                            ->label(__('alpha::filament/resources/account/infolist.entries.username.label'))
                            ->columnSpan(1),

                        TextEntry::make('email.value')
                            ->label(__('alpha::filament/resources/account/infolist.entries.email.label'))
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull()
                    ->columns(2),

                self::getRolesTabs(),
            ]);
    }

    public static function getRolesTabs(): Tabs
    {
        return Tabs::make(__('alpha::filament/resources/account/infolist.sections.roles.heading'))
            ->tabs(function ($record) {
                // Get owned teams first, then membership teams
                $ownedTeams = $record->ownedTeams;
                $membershipTeams = $record->teams;

                // Combine with owned teams first
                $allTeams = $ownedTeams->merge($membershipTeams)->unique('id');

                return $allTeams
                    ->map(function ($team) use ($record, $ownedTeams) {
                        $isOwner = $ownedTeams->contains('id', $team->id);

                        return Tab::make($team->name)
                            ->label($team->name)
                            ->badge($isOwner ? __('alpha::filament/resources/account/infolist.badges.owner') : null)
                            ->schema(self::getTeamRoleComponents($record, $team));
                    })
                    ->toArray();
            })
            ->columnSpanFull();
    }

    public static function getTeamRoleComponents($record, $team): array
    {
        // Get roles that belong to this team
        $teamRoles = Role::where('team_id', $team->id)
            ->get()
            ->mapToGroups(function (Role $role) {
                $group = Str::of($role->name)->before('::')->toString();

                return [$group => $role->name];
            });

        $components = $teamRoles
            ->map(function (Collection $roles, string $group) use ($record, $team) {
                return Fieldset::make(__("{$group}::module.name"))
                    ->schema(function () use ($roles, $record, $team) {
                        return $roles
                            ->map(function (string $role) use ($record, $team) {
                                return IconEntry::make('roles')
                                    ->label(__($role))
                                    ->boolean()
                                    ->inlineLabel()
                                    ->state(function () use ($record, $role, $team) {
                                        return $record->roles()
                                            ->wherePivot('team_id', $team->id)
                                            ->where('name', $role)
                                            ->exists();
                                    });
                            })
                            ->toArray();
                    })
                    ->columns(1)
                    ->columnSpan(1);
            })
            ->toArray();

        return [
            Grid::make()->schema($components),
        ];
    }
}

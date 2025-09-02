<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Aeon\Packages\Spatie\Permission\Models\Role;
use Venture\Alpha\Concerns\InteractsWithRoleFormComponents;

class EditRolesForm
{
    use InteractsWithRoleFormComponents;

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('team_id')
                ->label('Team')
                ->options(function (Model $record) {
                    return $record->allTeams()->pluck('name', 'id');
                })
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (Model $record, Get $get, ?int $state) use ($schema): void {
                    setPermissionsTeamId($state);

                    $assignedRoles = $record
                        ->roles
                        ->pluck('name');

                    $rolesFormData = Role::query()
                        ->where('team_id', $state)
                        ->get()
                        ->mapWithKeys(function (Role $role) use ($assignedRoles, $state) {
                            $fieldName = self::buildFieldName($role->name, $state);

                            return [$fieldName => $assignedRoles->contains($role->name)];
                        });

                    $schema->fill([
                        'team_id' => $state,
                        ...$rolesFormData,
                    ]);
                }),

            Grid::make(2)
                ->schema(function (Get $get) {
                    return self::getRoleComponents($get('team_id'));
                })
                ->hiddenJs(<<<'JS'
                    $get('team_id') === null
                JS),
        ]);
    }

    public static function getRoleComponents(?int $teamId): array
    {
        return Role::query()
            ->where('team_id', $teamId)
            ->get()
            ->mapToGroups(function (Role $role) {
                $group = Str::of($role->name)->before('::')->toString();

                return [$group => $role->name];
            })
            ->map(function (Collection $roles, string $group) use ($teamId) {
                return Fieldset::make(__("{$group}::module.name"))
                    ->schema(function () use ($roles, $teamId) {
                        return $roles
                            ->map(function (string $role) use ($teamId) {
                                $fieldName = self::buildFieldName($role, $teamId);

                                return Toggle::make($fieldName)
                                    ->label(__($role));
                            })
                            ->toArray();
                    })
                    ->columns(1)
                    ->columnSpan(1);
            })
            ->toArray();
    }
}

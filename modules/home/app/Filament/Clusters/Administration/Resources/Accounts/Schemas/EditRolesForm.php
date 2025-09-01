<?php

namespace Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Schemas;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Aeon\Packages\Spatie\Permission\Models\Role;

class EditRolesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(self::getRoleComponents());
    }

    public static function getRoleFieldMappings(): Collection
    {
        return Role::all()->mapWithKeys(function (Role $role) {
            $fieldName = Str::of($role->name)->replace('::', '__')->toString();

            return [$fieldName => $role->name];
        });
    }

    public static function getRoleComponents(): array
    {
        $roles = Role::all()
            ->mapToGroups(function (Role $role) {
                $group = Str::of($role->name)->before('::')->toString();

                return [$group => $role->name];
            })
            ->map(function (Collection $roles, string $group) {
                return Fieldset::make(__("{$group}::module.name"))
                    ->schema(function () use ($roles) {
                        return $roles
                            ->map(function (string $role) {
                                $name = Str::of($role)->replace('::', '__')->toString();

                                return Toggle::make("roles.{$name}")
                                    ->label(__($role));
                            })
                            ->toArray();
                    })
                    ->columns(1)
                    ->columnSpan(1);
            })
            ->toArray();

        return [
            Grid::make(2)->schema($roles),
        ];
    }
}

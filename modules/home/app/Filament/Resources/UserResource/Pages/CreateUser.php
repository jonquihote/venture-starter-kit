<?php

namespace Venture\Home\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Home\Filament\Resources\UserResource;
use Venture\Home\Models\User;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $roles = Collection::make($data['roles'])
            ->filter()
            ->keys();

        if ($roles->isEmpty()) {
            return parent::handleRecordCreation($data);
        }

        $roles = $roles
            ->map(function (string $role) {
                return Str::of($role)->replace('_', '.')->toString();
            })
            ->toArray();

        /** @var User $model */
        $model = parent::handleRecordCreation($data);
        $model->syncRoles($roles);

        return $model;
    }
}

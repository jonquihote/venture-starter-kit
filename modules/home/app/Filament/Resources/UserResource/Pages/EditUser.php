<?php

namespace Venture\Home\Filament\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Venture\Home\Filament\Resources\UserResource;
use Venture\Home\Models\User;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $roles = Collection::make($data['roles'])
            ->filter()
            ->keys()
            ->map(function (string $role) {
                return Str::of($role)->replace('_', '.')->toString();
            })
            ->toArray();

        /** @var User $model */
        $model = parent::handleRecordUpdate($record, $data);
        $model->syncRoles($roles);

        return $model;
    }
}

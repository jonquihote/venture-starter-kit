<?php

namespace Venture\Home\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Database\Eloquent\Builder;

class Login extends BaseLogin
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'password' => $data['password'],

            function (Builder $builder) use ($data): void {
                $builder->whereHas('credentials', function (Builder $builder) use ($data): void {
                    $builder->where('value', $data['email']);
                });
            },
        ];
    }
}

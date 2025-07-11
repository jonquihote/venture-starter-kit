<?php

namespace Venture\Home\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Venture\Aeon\Support\Facades\Access;
use Venture\Home\Models\User;

use function Laravel\Prompts\form;

class MakeUserCommand extends Command
{
    protected $signature = 'home:make:user';

    protected $description = 'Create a new user';

    public function handle(): int
    {
        $data = form()
            ->text(
                label: 'Name',
                validate: ['name' => ['required', 'regex:/^[\pL\s]+$/u']],
                name: 'name',
                transform: function (string $value) {
                    return Str::squish($value);
                },
            )
            ->text(
                label: 'Username',
                validate: ['username' => ['required', 'alpha_dash:ascii']],
                name: 'username',
            )
            ->text(
                label: 'E-Mail Address',
                validate: ['email' => ['required', 'email']],
                name: 'email',
            )
            ->password(
                label: 'Password',
                validate: ['password' => ['required', 'min:8']],
                name: 'password',
            )
            ->confirm(
                label: 'Make Administrator?',
                default: false,
                required: true,
                name: 'is_administrator'
            )
            ->submit();

        DB::transaction(function () use ($data): void {
            $user = User::create([
                'name' => $data['name'],
                'password' => $data['password'],
            ]);

            if ($data['is_administrator']) {
                $user->syncRoles(Access::administratorRoles());
            }

            $user->addUsername($data['username']);
            $user->addEmail($data['email']);
        });

        return self::SUCCESS;
    }
}

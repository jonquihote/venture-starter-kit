<?php

namespace Venture\Alpha\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Enums\AccountCredentialTypesEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;
use Venture\Alpha\Rules\ValidName;
use Venture\Alpha\Rules\ValidUsername;

use function Laravel\Prompts\form;

/**
 * @codeCoverageIgnore
 */
class MakeAccountCommand extends Command
{
    protected $signature = 'alpha:make:account';

    protected $description = 'Create a new account';

    public function handle(): int
    {
        $this->components->info('Creating a new account ...');

        $data = form()
            ->text(
                label: 'Name',
                placeholder: 'Jack Sparrow',
                validate: [
                    'name' => [
                        'required',
                        new ValidName,
                    ],
                ],
                name: 'name',
                transform: function (string $value) {
                    return Str::squish($value);
                }
            )
            ->text(
                label: 'Username',
                placeholder: 'jack.sparrow',
                validate: [
                    'username' => [
                        'required',
                        'min:4',
                        'max:16',
                        Rule::unique(AccountCredential::class, 'value')
                            ->where(function (Builder $query) {
                                return $query->where('type', AccountCredentialTypesEnum::Username);
                            }),
                        new ValidUsername,
                    ],
                ],
                name: 'username'
            )
            ->text(
                label: 'E-Mail Address',
                placeholder: 'jack.sparrow@example.com',
                validate: [
                    'email' => [
                        'required',
                        'email',
                        Rule::unique(AccountCredential::class, 'value')
                            ->where(function (Builder $query) {
                                return $query->where('type', AccountCredentialTypesEnum::Email);
                            }),
                    ],
                ],
                name: 'email'
            )
            ->password(
                label: 'Password',
                required: true,
                name: 'password'
            )
            ->confirm(
                label: 'Grant Super Administrator Role?',
                default: false,
                name: 'grant_super_administrator_role'
            )
            ->submit();

        $account = DB::transaction(function () use ($data) {
            $account = Account::create([
                'name' => Str::squish($data['name']),
                'password' => $data['password'],
            ]);

            $account->updateUsername($data['username']);
            $account->updateEmail($data['email']);

            if ($data['grant_super_administrator_role']) {
                $account->syncRoles(Access::administratorRoles());
            }

            return $account;
        });

        $this->components->success(
            sprintf(
                'Account "%s" created successfully%s',
                $account->name,
                $data['grant_super_administrator_role'] ? ' with administrator privileges' : ''
            )
        );

        return self::SUCCESS;
    }
}

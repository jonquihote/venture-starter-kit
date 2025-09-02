<?php

namespace Venture\Alpha\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Venture\Alpha\Enums\AccountCredentialTypesEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;
use Venture\Alpha\Rules\ValidName;
use Venture\Alpha\Rules\ValidUsername;

class AccountImporter extends Importer
{
    protected static ?string $model = Account::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules([
                    'required',
                    new ValidName,
                ])
                ->castStateUsing(function (string $state): string {
                    return Str::squish($state);
                })
                ->examples(['Dale Carnegie', 'Brené Brown', 'James Clear']),

            ImportColumn::make('username')
                ->requiredMapping()
                ->rules([
                    'required',
                    'min:4',
                    'max:16',
                    Rule::unique(AccountCredential::class, 'value')
                        ->where(function (Builder $query) {
                            return $query->where('type', AccountCredentialTypesEnum::Username);
                        }),
                    new ValidUsername,
                ])
                ->examples(['dale.carnegie', 'brene.brown', 'james.clear'])
                ->fillRecordUsing(function (Account $record, string $state): void {
                    // Do not fill directly into Account model
                    // This will be handled in afterSave() hook
                }),

            ImportColumn::make('email')
                ->requiredMapping()
                ->rules([
                    'required',
                    'email',
                    Rule::unique(AccountCredential::class, 'value')
                        ->where(function (Builder $query) {
                            return $query->where('type', AccountCredentialTypesEnum::Email);
                        }),
                ])
                ->examples(['dale.carnegie@example.com', 'brene.brown@example.net', 'james.clear@example.org'])
                ->fillRecordUsing(function (Account $record, string $state): void {
                    // Do not fill directly into Account model
                    // This will be handled in afterSave() hook
                }),
        ];
    }

    public function resolveRecord(): ?Account
    {
        return new Account;
    }

    protected function beforeSave(): void
    {
        // Generate a secure random password
        $this->record->password = Str::random(32);
    }

    protected function afterSave(): void
    {
        // Create username and email credentials using the model methods
        $this->record->updateUsername($this->data['username']);
        $this->record->updateEmail($this->data['email']);
    }

    public function getValidationMessages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'username.required' => 'The username field is required.',
            'username.min' => 'The username must be at least 4 characters.',
            'username.max' => 'The username must not be greater than 16 characters.',
            'username.unique' => 'The username is already taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email is already taken.',
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your account import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

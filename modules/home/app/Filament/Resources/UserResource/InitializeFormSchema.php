<?php

namespace Venture\Home\Filament\Resources\UserResource;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;
use Venture\Aeon\Models\Role;

class InitializeFormSchema extends Action
{
    protected string $langPre = 'home::filament/resources/user/form';

    protected function getFormFields(): array
    {
        return [
            TextInput::make('name')
                ->label("{$this->langPre}.fields.name.label")
                ->translateLabel()
                ->required(),

            TextInput::make('email')
                ->label("{$this->langPre}.fields.email.label")
                ->translateLabel()
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),

            TextInput::make('password')
                ->label("{$this->langPre}.fields.password.label")
                ->translateLabel()
                ->password()
                ->revealable()
                ->confirmed()
                ->required()
                ->visibleOn('create'),

            TextInput::make('password_confirmation')
                ->label("{$this->langPre}.fields.password_confirmation.label")
                ->translateLabel()
                ->password()
                ->revealable()
                ->required()
                ->visibleOn('create'),
        ];
    }

    protected function getRolesFields(): array
    {
        $roles = Role::all()
            ->mapToGroups(function (Role $role) {
                $group = Str::of($role->name)->before('::')->toString();

                return [$group => $role->name];
            })
            ->map(function (Collection $roles, string $group) {
                return Fieldset::make("aeon::modules.{$group}.label")
                    ->translateLabel()
                    ->schema(function () use ($roles) {
                        return $roles
                            ->map(function (string $role) {
                                $name = Str::of($role)->replace('.', '_')->toString();

                                return Toggle::make("roles.{$name}")
                                    ->label($role)
                                    ->translateLabel()
                                    ->afterStateHydrated(function (?Model $record, Toggle $component) use ($role): void {
                                        $state = $record?->roles->contains('name', $role);

                                        $component->state($state);
                                    });
                            })
                            ->toArray();
                    })
                    ->columns(1)
                    ->columnSpan(1);
            })
            ->toArray();

        return [
            Grid::make(2)
                ->schema($roles),
        ];
    }

    public function handle(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema($this->getFormFields()),
            Section::make(__("{$this->langPre}.sections.roles.label"))->schema($this->getRolesFields()),
        ]);
    }
}

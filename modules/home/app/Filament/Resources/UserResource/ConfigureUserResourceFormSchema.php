<?php

namespace Venture\Home\Filament\Resources\UserResource;

use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;
use Venture\Aeon\Packages\Spatie\Permissions\Role;
use Venture\Home\Enums\UserCredentialTypesEnum;

class ConfigureUserResourceFormSchema extends Action
{
    protected string $langPre = 'home::filament/resources/user/form';

    protected function getFormFields(): array
    {
        return [
            TextInput::make('name')
                ->label("{$this->langPre}.fields.name.label")
                ->translateLabel()
                ->required()
                ->columnSpanFull(),

            TextInput::make('password')
                ->label("{$this->langPre}.fields.password.label")
                ->translateLabel()
                ->password()
                ->revealable()
                ->confirmed()
                ->required()
                ->visibleOn('create')
                ->columnSpanFull(),

            TextInput::make('password_confirmation')
                ->label("{$this->langPre}.fields.password_confirmation.label")
                ->translateLabel()
                ->password()
                ->revealable()
                ->required()
                ->visibleOn('create')
                ->columnSpanFull(),

            $this->getUsernameRepeaterField(),
            $this->getEmailRepeaterField(),
        ];
    }

    protected function getUsernameRepeaterField(): Repeater
    {
        return Repeater::make('usernames')
            ->label(__("{$this->langPre}.sections.usernames.label"))
            ->addActionLabel(__("{$this->langPre}.sections.usernames.add-action-label"))
            ->relationship()
            ->schema([
                Grid::make(8)
                    ->schema([
                        TextInput::make('value')
                            ->hiddenLabel()
                            ->alphaNum()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->columnSpan(7),

                        Toggle::make('is_primary')
                            ->hiddenLabel()
                            ->fixIndistinctState(),
                    ])
                    ->extraAttributes([
                        'class' => 'grid-vertically-centered-container',
                    ]),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                $data['type'] = UserCredentialTypesEnum::USERNAME;

                return $data;
            })
            ->rules([
                function (): Closure {
                    return function (string $attribute, mixed $value, Closure $fail): void {
                        $atLeastOneTrue = Collection::make($value)->pluck('is_primary')->contains(true);

                        if (! $atLeastOneTrue) {
                            $fail(__("{$this->langPre}.sections.usernames.validation-messages.at-least-one-true"));
                        }
                    };
                },
            ])
            ->columnSpan(1)
            ->minItems(1)
            ->maxItems(3);
    }

    protected function getEmailRepeaterField(): Repeater
    {
        return Repeater::make('emails')
            ->label(__("{$this->langPre}.sections.emails.label"))
            ->addActionLabel(__("{$this->langPre}.sections.emails.add-action-label"))
            ->relationship()
            ->schema([
                Grid::make(8)
                    ->schema([
                        TextInput::make('value')
                            ->hiddenLabel()
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->columnSpan(7),

                        Toggle::make('is_primary')
                            ->hiddenLabel()
                            ->fixIndistinctState(),
                    ])
                    ->extraAttributes([
                        'class' => 'grid-vertically-centered-container',
                    ]),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                $data['type'] = UserCredentialTypesEnum::EMAIL;

                return $data;
            })
            ->rules([
                function (): Closure {
                    return function (string $attribute, mixed $value, Closure $fail): void {
                        $atLeastOneTrue = Collection::make($value)->pluck('is_primary')->contains(true);

                        if (! $atLeastOneTrue) {
                            $fail(__("{$this->langPre}.sections.emails.validation-messages.at-least-one-true"));
                        }
                    };
                },
            ])
            ->columnSpan(1)
            ->minItems(1)
            ->maxItems(3);
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
            Section::make()->schema($this->getFormFields())->columns(2),
            Section::make(__("{$this->langPre}.sections.roles.label"))->schema($this->getRolesFields()),
        ]);
    }
}

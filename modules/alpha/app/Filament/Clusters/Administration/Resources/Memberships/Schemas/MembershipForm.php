<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Memberships\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;
use Venture\Alpha\Models\Membership;

class MembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('account_id')
                    ->label(__('alpha::filament/resources/membership/form.fields.account.label'))
                    ->relationship('account', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(
                        table: Membership::class,
                        modifyRuleUsing: function (Unique $rule, Get $get) {
                            return $rule->where('team_id', $get('team_id'));
                        }
                    )
                    ->validationMessages([
                        'unique' => __('alpha::filament/resources/membership/form.validation.unique.account_already_member'),
                    ])
                    ->columnSpanFull(),

                Select::make('team_id')
                    ->label(__('alpha::filament/resources/membership/form.fields.team.label'))
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}

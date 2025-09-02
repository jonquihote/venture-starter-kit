<?php

namespace Venture\Alpha\Filament\Clusters\Administration\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;
use Venture\Alpha\Models\Subscription;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('team_id')
                    ->label(__('alpha::filament/resources/subscription/form.fields.team.label'))
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(
                        table: Subscription::class,
                        modifyRuleUsing: function (Unique $rule, $get) {
                            return $rule->where('application_id', $get('application_id'));
                        }
                    )
                    ->validationMessages([
                        'unique' => __('alpha::filament/resources/subscription/form.validation.unique.team_already_subscribed'),
                    ])
                    ->columnSpanFull(),

                Select::make('application_id')
                    ->label(__('alpha::filament/resources/subscription/form.fields.application.label'))
                    ->relationship('application', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}

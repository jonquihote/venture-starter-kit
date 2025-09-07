<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('blueprint::filament/resources/posts/table.columns.title.label'))
                    ->icon(function (Model $record) {
                        return $record->is_home_page ? 'lucide-house' : null;
                    })
                    ->iconColor('success')
                    ->searchable(),

                TextColumn::make('documentation_group')
                    ->label(__('blueprint::filament/resources/posts/table.columns.documentation_group.label')),

                TextColumn::make('updated_at')
                    ->label(__('blueprint::filament/resources/posts/table.columns.updated_at.label'))
                    ->dateTime('d M y')
                    ->description(function (Carbon $state) {
                        return $state->format('H:i');
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('blueprint::filament/resources/posts/table.columns.created_at.label'))
                    ->dateTime('d M y')
                    ->description(function (Carbon $state) {
                        return $state->format('H:i');
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

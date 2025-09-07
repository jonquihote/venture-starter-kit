<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Venture\Blueprint\Enums\DocumentationGroupsEnum;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('blueprint::filament/resources/posts/form.fields.title.label'))
                            ->required(),

                        MarkdownEditor::make('content')
                            ->label(__('blueprint::filament/resources/posts/form.fields.content.label'))
                            ->required(),
                    ])
                    ->columnSpan(3),

                Section::make()
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('blueprint::filament/resources/posts/form.fields.slug.label'))
                            ->hiddenOn('create')
                            ->required(),

                        Select::make('documentation_group')
                            ->label(__('blueprint::filament/resources/posts/form.fields.documentation_group.label'))
                            ->options(DocumentationGroupsEnum::class)
                            ->required(),

                        Toggle::make('is_home_page')
                            ->label(__('blueprint::filament/resources/posts/form.fields.is_home_page.label')),
                    ]),
            ])
            ->columns(4);
    }
}

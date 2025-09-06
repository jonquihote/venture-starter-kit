<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Venture\Blueprint\Filament\Clusters\Documentation\DocumentationCluster;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Pages\CreatePost;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Pages\EditPost;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Pages\ListPosts;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Schemas\PostForm;
use Venture\Blueprint\Filament\Clusters\Documentation\Resources\Posts\Tables\PostsTable;
use Venture\Blueprint\Models\Post;

class PostResource extends Resource
{
    protected static ?string $cluster = DocumentationCluster::class;

    protected static ?string $model = Post::class;

    protected static string | BackedEnum | null $navigationIcon = 'lucide-notebook-text';

    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}

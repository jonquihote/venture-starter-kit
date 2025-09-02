<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Home\Enums\MigrationsEnum;

class Application extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'page',
        'icon',

        'is_subscribed_by_default',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Applications->table();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}

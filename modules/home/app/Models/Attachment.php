<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Venture\Home\Database\Factories\AttachmentFactory;
use Venture\Home\Enums\MigrationsEnum;

#[UseFactory(AttachmentFactory::class)]
class Attachment extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'downloads_count',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::Attachments->table();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function fileName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->getFirstMedia()->file_name;
            }
        );
    }

    public function mediaPath(): string
    {
        return $this->getFirstMediaPath();
    }

    public function downloadUrl(): string
    {
        return route('@home.attachments.download', [$this]);
    }
}

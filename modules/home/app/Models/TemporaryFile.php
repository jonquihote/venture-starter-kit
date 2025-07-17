<?php

namespace Venture\Home\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Venture\Aeon\Packages\Spatie\MediaLibrary\Concerns\InteractsWithMedia;
use Venture\Home\Database\Factories\TemporaryFileFactory;
use Venture\Home\Enums\MigrationsEnum;

#[UseFactory(TemporaryFileFactory::class)]
class TemporaryFile extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'downloads_count',
    ];

    public function getTable(): string
    {
        return MigrationsEnum::TEMPORARY_FILES->table();
    }

    public function assetUrl(): string
    {
        return $this->getFirstMediaUrl();
    }

    public function downloadUrl(): string
    {
        return route('@home.temporary-files.download', [
            'file' => $this,
        ]);
    }

    public function path(): string
    {
        return $this->getFirstMediaPath();
    }
}

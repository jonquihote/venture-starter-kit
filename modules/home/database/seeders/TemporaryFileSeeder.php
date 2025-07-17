<?php

namespace Venture\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Venture\Home\Models\TemporaryFile;

class TemporaryFileSeeder extends Seeder
{
    public function run(): void
    {
        $files = TemporaryFile::factory()
            ->count(10)
            ->create();

        $fakes = Collection::make(File::files(base_path('stubs')));

        $files->each(function (TemporaryFile $file) use ($fakes): void {
            $file
                ->addMedia($fakes->random())
                ->preservingOriginal()
                ->toMediaCollection();
        });
    }
}

<?php

namespace Venture\Alpha\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Venture\Alpha\Models\Attachment;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        $stubs = Collection::make(File::files(base_path('stubs/fake-files')));

        Attachment::factory()
            ->count(10)
            ->create()
            ->each(function (Attachment $attachment) use ($stubs): void {
                $attachment
                    ->addMedia($stubs->random())
                    ->preservingOriginal()
                    ->toMediaCollection();
            });
    }
}

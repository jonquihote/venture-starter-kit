<?php

namespace Venture\Aeon\Packages\Filament\Filament\Providers;

use Filament\Actions\Exports\Models\Export as BaseExport;
use Filament\Actions\Imports\Models\FailedImportRow as BaseFailedImportRow;
use Filament\Actions\Imports\Models\Import as BaseImport;
use Illuminate\Support\ServiceProvider;
use Venture\Aeon\Packages\Filament\Filament\Models\Export;
use Venture\Aeon\Packages\Filament\Filament\Models\FailedImportRow;
use Venture\Aeon\Packages\Filament\Filament\Models\Import;

class FilamentDataProcessingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->configureBindings();
    }

    public function boot(): void {}

    protected function configureBindings(): void
    {
        $this->app->bind(BaseExport::class, Export::class);
        $this->app->bind(BaseImport::class, Import::class);
        $this->app->bind(BaseFailedImportRow::class, FailedImportRow::class);
    }
}

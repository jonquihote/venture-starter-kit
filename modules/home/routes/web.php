<?php

use Illuminate\Support\Facades\Route;
use Venture\Home\Http\Controllers\TemporaryFileDownloadController;

Route::group([
    'middleware' => ['auth'],
], function (): void {
    Route::group([
        'middleware' => ['verified'],
    ], function (): void {
        //
    });

    Route::get('temporary-files/{file}/download', TemporaryFileDownloadController::class)
        ->name('temporary-files.download');
});

Route::group([
    'middleware' => ['guest'],
], function (): void {
    //
});

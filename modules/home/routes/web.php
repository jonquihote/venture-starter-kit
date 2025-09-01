<?php

use Illuminate\Support\Facades\Route;
use Venture\Home\Http\Controllers\AttachmentDownloadController;

Route::group([
    'middleware' => ['auth'],
], function (): void {
    Route::group([
        'middleware' => ['verified'],
    ], function (): void {
        //
    });

    Route::get('attachments/{attachment:slug}/download', AttachmentDownloadController::class)
        ->name('attachments.download');
});

Route::group([
    'middleware' => ['guest'],
], function (): void {
    //
});

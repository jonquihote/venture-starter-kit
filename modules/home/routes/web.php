<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth'],
], function (): void {
    Route::group([
        'middleware' => ['verified'],
    ], function (): void {
        //
    });
});

Route::group([
    'middleware' => ['guest'],
], function (): void {
    //
});

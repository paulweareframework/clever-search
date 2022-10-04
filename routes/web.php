<?php

use Weareframework\CleverSearch\Http\Controllers\Api\SearchController;

Route::prefix('clever-search')->group(function () {
    Route::match(['GET', 'POST'], '/search', ['\\' . SearchController::class, 'index'])->name('weareframework.clever-search.api.search.index');
});


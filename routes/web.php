<?php

use Weareframework\CleverSearch\Http\Controllers\Api\SearchController;

Route::prefix('clever-search')->group(function () {
  Route::get('/search', ['\\' . SearchController::class, 'index'])->name('weareframework.clever-search.api.search.index');
});


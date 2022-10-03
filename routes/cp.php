<?php

use Weareframework\CleverSearch\Http\Controllers\Web\DashboardController;
use Weareframework\CleverSearch\Http\Controllers\Web\SettingsController;


Route::prefix('weareframework/clever-search')->group(function () {
    Route::get('/', ['\\'. DashboardController::class, 'index'])->name('weareframework.clever-search.dashboard.index');
    Route::get('/settings', ['\\'. SettingsController::class, 'index'])->name('weareframework.clever-search.settings.index');
    Route::post('/settings', ['\\'. SettingsController::class, 'update'])->name('weareframework.clever-search.settings.update');
    Route::get('/update-search-indexes', ['\\'. SettingsController::class, 'updateIndexes'])->name('weareframework.clever-search.settings.update-search-indexes');
});


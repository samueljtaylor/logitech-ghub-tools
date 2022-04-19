<?php

use App\Http\Controllers\Api\RepositoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('repository')->as('repository.')->group(function () {
    Route::get('hasChanged', [RepositoryController::class, 'hasChanged'])->name('hasChanged');
    Route::get('lastUpdated', [RepositoryController::class, 'lastUpdated'])->name('lastUpdated');
    Route::get('settings', [RepositoryController::class, 'settings'])->name('settings');
    Route::get('reload', [RepositoryController::class, 'reload'])->name('reload');
});

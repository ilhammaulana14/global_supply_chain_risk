<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\WeatherController;
use App\Http\Controllers\Admin\PortController;
use App\Http\Controllers\Admin\EconomyController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RiskScoreController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Countries
    |--------------------------------------------------------------------------
    */
    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');


    /*
    |--------------------------------------------------------------------------
    | Weather
    |--------------------------------------------------------------------------
    */
    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather.index');

    Route::post('/weather/refresh', [WeatherController::class, 'refreshAll'])
        ->name('weather.refresh');

    Route::post('/weather/{id}', [WeatherController::class, 'update'])
        ->name('weather.update');


    /*
    |--------------------------------------------------------------------------
    | Ports
    |--------------------------------------------------------------------------
    */
    Route::get('/ports', [PortController::class, 'index'])
        ->name('ports.index');

        Route::post(
    '/ports/import',
    [PortController::class, 'import']
)->name('ports.import');


    /*
    |--------------------------------------------------------------------------
    | Economy
    |--------------------------------------------------------------------------
    */
    Route::get('/economy', [EconomyController::class, 'index'])
        ->name('economy.index');

    Route::post('/economy/import', [EconomyController::class, 'import'])
        ->name('economy.import');


    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */
    Route::get('/news', [NewsController::class, 'index'])
        ->name('news.index');

    Route::post('/news/generate', [NewsController::class, 'generate'])
        ->name('news.generate');


    /*
    |--------------------------------------------------------------------------
    | Risk Score
    |--------------------------------------------------------------------------
    */
    Route::get('/risk-scores', [RiskScoreController::class, 'index'])
        ->name('risk-scores.index');

    Route::get('/risk-scores/generate', [RiskScoreController::class, 'generate'])
        ->name('risk.generate');

});

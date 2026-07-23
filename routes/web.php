<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Admin\WeatherController;
use App\Http\Controllers\Admin\PortController;
use App\Http\Controllers\Admin\EconomyController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RiskScoreController;
use App\Http\Controllers\ComparisonController;

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

    Route::post('/countries/{country}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])
        ->name('countries.favorite');


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

        Route::get('/comparison', [ComparisonController::class, 'index'])
    ->name('comparison.index');

Route::post('/comparison', [ComparisonController::class, 'compare'])
    ->name('comparison.compare');

});

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminPortController;



Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){

        Route::get('/dashboard',
            [AdminDashboardController::class,'index']
        )->name('dashboard');

        Route::resource('users', UserController::class);

        Route::resource('ports', AdminPortController::class);

        // Route::resource('articles', ArticleController::class);

    });

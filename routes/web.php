<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Installer\FinalController;
use App\Http\Controllers\Installer\UpdateController;
use App\Http\Controllers\Installer\WelcomeController;
use App\Http\Controllers\Installer\DatabaseController;
use App\Http\Controllers\Installer\EnvironmentController;
use App\Http\Controllers\Installer\PermissionsController;
use App\Http\Controllers\Installer\RequirementsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'install', 'as' => 'LaravelInstaller::', 'middleware' => ['web', 'install']], function () {
    Route::get('/', [WelcomeController::class,'welcome'])->name('welcome');

    Route::get('environment', [EnvironmentController::class,'environmentMenu'])->name('environment');

    Route::get('environment/wizard', [EnvironmentController::class,'environmentWizard'])->name('environmentWizard');

    Route::post('environment/saveWizard', [EnvironmentController::class, 'saveWizard'])->name('environmentSaveWizard');

    Route::get('environment/classic', [EnvironmentController::class,'environmentClassic'])->name('environmentClassic');

    Route::post('environment/saveClassic', [EnvironmentController::class,'saveClassic'])->name('environmentSaveClassic');

    Route::get('requirements', [RequirementsController::class,'requirements',
    ])->name('requirements');

    Route::get('permissions', [PermissionsController::class,'permissions'])->name('permissions');

    Route::get('database', [DatabaseController::class,'database'])->name('database');

    Route::get('final', [FinalController::class,'finish'])->name('final');
});

Route::group(['prefix' => 'update', 'as' => 'LaravelUpdater::', 'middleware' => 'web'], function () {
    Route::group(['middleware' => 'update'], function () {
        Route::get('/', [UpdateController::class,'welcome'])->name('welcome');

        Route::get('overview', [UpdateController::class,'overview'])->name('overview');

        Route::get('database', [UpdateController::class,'database'])->name('database');
    });

    // This needs to be out of the middleware because right after the migration has been
    // run, the middleware sends a 404.
    Route::get('final', [UpdateController::class,'finish'])->name('final');
});

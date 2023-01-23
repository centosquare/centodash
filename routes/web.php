<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\langController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\LanguageTranslationController;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('login',  'loginView')->name('login');
        Route::post('login-user', 'userLogin')->name('login.user');
        Route::get('register',  'registerView')->name('register');
        Route::post('check-register', 'checkRegister')->name('check.register');
        Route::get('logout', 'logout')->name('logout');
    });

Route::middleware('auth')->group(function () {

    Route::controller(UserController::class)
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{user}', 'edit')->name('edit');
            Route::post('update/{user}', 'update')->name('update');
            Route::get('delete/{user}', 'destroy')->name('delete');
        });

    Route::controller(RoleController::class)
        ->prefix('role')
        ->name('role.')
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{role}', 'edit')->name('edit');
            Route::post('update/{role}', 'update')->name('update');
            Route::get('delete/{role}', 'destroy')->name('delete');
        });

    Route::view('/', 'welcome');
    Route::controller(PermissionController::class)
        ->prefix('permission')
        ->name('permission.')
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{permission}', 'edit')->name('edit');
            Route::post('update{permission}', 'update')->name('update');
            Route::get('delete/{permission}', 'destroy')->name('delete');
            Route::get('synchronize', 'synchronize')->name('synchronize');
        });

    Route::controller(langController::class)
        ->prefix('change-language')
        ->name('change-language.')
        ->group(function () {
            Route::get('/changeLanguage/{language}', 'languageChanger')->name('language');
            Route::get('/test', 'getFile');
        });


    Route::controller(LanguageTranslationController::class)->group(function () {
        Route::get('languages', 'index')->name('languages');
        Route::post('translations/update', 'transUpdate')->name('translation.update.json');
        Route::post('translations/updateKey', 'transUpdateKey')->name('translation.update.json.key');
        Route::get('translations/destroy/{key}', 'destroy')->name('translations.destroy');
        Route::post('translations/create',  'store')->name('translations.create');
        Route::get('add/Language',  'createLanguage')->name('addLanguage');
        Route::post('create/Language',  'addLanguage')->name('createLanguage');
        Route::get('create/config',  'newlyConfig')->name('newlyConfig');
        Route::get('/delete/{language}',  'deleteLanguage')->name('delete');
    });
});

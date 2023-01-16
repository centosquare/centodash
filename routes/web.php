<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

// for components testing purpose
Route::view('/', 'welcome');

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


// Route::view('/', 'admin.language.localization');

Route::controller(langController::class)
    ->prefix('change-language')
    ->name('change-language.')
    ->group(function () {

        Route::get('/changeLanguage/{language}', 'languageChanger')->name('language');

        Route::get('/test', 'getFile');
    });

Route::get('languages', [LanguageTranslationController::class, 'index'])->name('languages');

Route::post('translations/update', [LanguageTranslationController::class, 'transUpdate'])->name('translation.update.json');

Route::post('translations/updateKey', [LanguageTranslationController::class, 'transUpdateKey'])->name('translation.update.json.key');

Route::delete('translations/destroy/{key}', [LanguageTranslationController::class, 'destroy'])->name('translations.destroy');

Route::post('translations/create',  [LanguageTranslationController::class, 'store'])->name('translations.create');

Route::get('add/Language',  [LanguageTranslationController::class, 'createLanguage'])->name('addLanguage');

Route::post('create/Language',  [LanguageTranslationController::class, 'addLanguage'])->name('createLanguage');

Route::get('create/config',  [LanguageTranslationController::class, 'newlyConfig'])->name('newlyConfig');

Route::get('/delete/{language}',  [LanguageTranslationController::class, 'deleteLanguage'])->name('delete');

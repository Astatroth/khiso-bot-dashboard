<?php

use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ShortcutController;
use App\Http\Controllers\TelegramChannelController;
use App\Http\Controllers\TranslationManagerController;
use Illuminate\Support\Facades\Route;


Route::prefix(LaravelLocalization::setLocale())->middleware('localeSessionRedirect')->group(function () {

    Route::prefix('dashboard')
         ->name('admin.')
         ->middleware(['auth', 'permission:access_dashboard'])
         ->group(function () {

             /*
              * Home
              */
             Route::get('/', [DashboardController::class, 'showDashboard'])->name('home');

             /*
              * Shortcut
              */
             Route::prefix('shortcut')->name('shortcut.')->group(function () {

                 Route::controller(ShortcutController::class)->group(function () {

                     Route::post('/toggle', 'ajaxToggle')
                          ->name('toggle');

                     Route::post('/remove', 'ajaxRemove')
                          ->name('remove');
                 });
             });

             /*
             * LFM
             */
             Route::group([
                 'prefix' => 'laravel-filemanager',
                 'middleware' => 'permission:use_file_manager'
             ], function () {
                 \UniSharp\LaravelFilemanager\Lfm::routes();
             });

             /*
             * SEO
             */
             Route::prefix('seo')
                  ->name('seo.')
                  ->middleware('permission:manage_seo')
                  ->group(function () {

                      Route::controller(SeoController::class)->group(function () {

                          Route::get('/', 'showList')->name('list');
                          Route::get('/add', 'showForm')->name('add');
                          Route::get('/{id}/edit', 'showForm')
                               ->whereNumber('id')
                               ->name('edit');

                          Route::post('/save', 'save')->name('save');
                          Route::post('/load', 'ajaxLoadList')->name('load');
                          Route::post('/delete', 'ajaxDelete')->name('delete');

                      });

                  });

             /*
             * Translation manager
             */
             Route::prefix('translations')
                  ->name('translation.')
                  ->middleware('permission:manage_translations')
                  ->group(function () {

                      Route::controller(TranslationManagerController::class)->group(function () {

                          Route::get('/', 'showTranslationManager')->name('show');

                          Route::post('/import', 'ajaxImportTranslations')->name('import');
                          Route::post('/discover', 'ajaxDiscoverTranslations')->name('discover');
                          Route::post('/groups', 'ajaxLoadGroups')->name('group.load');
                          Route::post('/load', 'ajaxLoadTranslations')->name('load');
                          Route::post('/save', 'ajaxSaveTranslation')->name('save');
                          Route::post('/publish', 'ajaxPublishTranslations')->name('publish');

                      });

                  });

             /*
              * Artisan
              */
             Route::prefix('artisan')
                  ->name('artisan.')
                  ->middleware('permission:use_artisan_gui')
                  ->controller(ArtisanController::class)
                  ->group(function () {

                      Route::get('/', 'showInterface')->name('show');

                      Route::post('/execute', 'executeCommand')->name('execute');

                  });

             Route::prefix('channels')
                  ->name('channels.')
                  ->middleware('permission:manage_settings')
                  ->controller(TelegramChannelController::class)
                  ->group(function () {

                      Route::get('/', 'showList')->name('list');
                      Route::get('/add', 'showForm')->name('add');
                      Route::get('/{id}/edit', 'showForm')->whereNumber('id')->name('edit');

                      Route::post('/load', 'ajaxLoadList')->name('load');
                      Route::post('/save', 'save')->name('save');
                      Route::post('/delete', 'ajaxDelete')->name('delete');
                  });
         });

    /*
     * Auth routes
     */
    Route::middleware('guest')->group(function () {

        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth')->group(function () {

        Route::any('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::any('/', function () {
        return redirect()->route('admin.home');
    });
});

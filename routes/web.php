<?php

use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OlympiadController;
use App\Http\Controllers\OlympiadResultController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ShortcutController;
use App\Http\Controllers\StudentController;
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

             /*
              * Channels
              */
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

             /*
              * News
              */
             Route::prefix('news')
                  ->name('news.')
                  ->middleware('permission:manage_content')
                  ->controller(NewsController::class)
                  ->group(function () {

                      Route::get('/', 'showList')->name('list');
                      Route::get('/add', 'showForm')->name('add');
                      Route::get('/{id}/edit', 'showForm')->whereNumber('id')->name('edit');

                      Route::post('/load', 'ajaxLoadList')->name('load');
                      Route::post('/save', 'save')->name('save');
                      Route::post('/delete', 'ajaxDelete')->name('delete');
                  });

             /*
              * Olympiads
              */
             Route::prefix('olympiad')
                  ->name('olympiad.')
                  ->middleware('permission:manage_content')
                  ->group(function () {

                      Route::controller(OlympiadController::class)->group(function () {
                          Route::get('/', 'showList')->name('list');
                          Route::get('/add', 'showForm')->name('add');
                          Route::get('/{id}/edit', 'showForm')->whereNumber('id')->name('edit');

                          Route::post('/load', 'ajaxLoadList')->name('load');
                          Route::post('/save', 'save')->name('save');
                          Route::post('/delete', 'ajaxDelete')->name('delete');
                      });

                      Route::controller(OlympiadResultController::class)->group(function () {
                          Route::get('/{id}/results', 'showList')->name('result.list');
                          Route::get('/{id}/results/{result_id}/view', 'showForm')
                              ->whereNumber('result_id')
                              ->name('result.view');
                          Route::post('/button/resend', 'ajaxResendButton')
                               ->name('button.resend');
                          Route::get('/{id}/results/export', 'export')->name('result.export');

                          Route::post('/results/load', 'ajaxLoadList')->name('result.load');
                      });

                      Route::controller(QuestionController::class)->group(function () {
                          Route::get('/{olympiad_id}/question/list', 'showList')
                               ->whereNumber('course_id')->name('question.list');
                          Route::get('/{olympiad_id}/question/add', 'showForm')
                               ->whereNumber('olympiad_id')->name('question.add');
                          Route::get('/{olympiad_id}/question/{id}/edit', 'showForm')
                               ->whereNumber(['olympiad_id', 'id'])->name('question.edit');

                          Route::post('/question/load', 'ajaxLoadList')->name('question.load');
                          Route::post('/question/save', 'save')->name('question.save');
                          Route::post('/question/delete', 'ajaxDelete')->name('question.delete');

                          Route::post('/question/import', 'import')->name('question.import');
                          Route::get('/question/template', 'downloadTemplate')->name('question.template');
                      });
                  });

             /*
              * Students
              */

             Route::prefix('users')
                  ->name('student.')
                  ->middleware('permission:manage_content')
                  ->controller(StudentController::class)
                  ->group(function () {
                      Route::get('/', 'showList')->name('list');

                      Route::post('/load', 'ajaxLoadList')->name('load');
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

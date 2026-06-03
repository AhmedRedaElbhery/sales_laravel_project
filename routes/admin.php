<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Admin_panel_settingsController;

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


Route::group([
    'namespace' => 'admin',
    'prefix' => 'admin',
    'middleware' => 'auth:admin'
], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/adminpanelsettings/show', [Admin_panel_settingsController::class, 'index'])->name('admin.adminpanelsettings.index');
    Route::get('/adminpanelsettings/edit', [Admin_panel_settingsController::class, 'edit'])->name('admin.adminpanelsettings.edit');
    Route::post('/adminpanelsettings/update', [Admin_panel_settingsController::class, 'update'])->name('admin.adminpanelsettings.update');




});


Route::group([
    'namespace' => 'admin',
    'prefix' => 'admin',
    'middleware' => 'guest:admin'
], function () {

    Route::get('login', [LoginController::class, 'show_login_view'])->name('admin.showlogin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});
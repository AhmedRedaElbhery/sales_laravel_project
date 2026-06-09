<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminPanelSettingsController;
use App\Http\Controllers\Admin\SalesMaterialTypesController;
use App\Http\Controllers\Admin\TreasuriesController;

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
    Route::get('/adminpanelsettings/show', [AdminPanelSettingsController::class, 'index'])->name('admin.adminpanelsettings.index');
    Route::get('/adminpanelsettings/edit', [AdminPanelSettingsController::class, 'edit'])->name('admin.adminpanelsettings.edit');
    Route::post('/adminpanelsettings/update', [AdminPanelSettingsController::class, 'update'])->name('admin.adminpanelsettings.update');
    /* Start Treasuries Routes */

    Route::get('/treasuries/index', [TreasuriesController::class, 'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/create', [TreasuriesController::class, 'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store', [TreasuriesController::class, 'store'])->name('admin.treasuries.store');
    Route::get('/treasuries/edit/{id}', [TreasuriesController::class, 'edit'])->name('admin.treasuries.edit');
    Route::put('/treasuries/update/{id}', [TreasuriesController::class, 'update'])->name('admin.treasuries.update');
    Route::get('/treasuries/details/{id}', [TreasuriesController::class, 'details'])->name('admin.treasuries.details');
    Route::delete('/treasuries/delete/{id}', [TreasuriesController::class, 'delete'])->name('admin.treasuries.delete');
    Route::get('/treasuries/add_treasuries_branch/{id}', [TreasuriesController::class, 'add_treasuries_branch'])->name('admin.treasuries.add_treasuries_branch');
    Route::post('/treasuries/store_treasuries_branch/{id}', [TreasuriesController::class, 'store_treasuries_branch'])->name('admin.treasuries.store_treasuries_branch');
    /*start Sales Material */

    Route::get('/sales/index', [SalesMaterialTypesController::class, 'index'])->name('admin.sales_material.index');
    Route::get('/sales/create', [SalesMaterialTypesController::class, 'create'])->name('admin.sales_material.create');
    Route::post('/sales/store', [SalesMaterialTypesController::class, 'store'])->name('admin.sales_material.store');
    Route::get('/sales/edit/{id}', [SalesMaterialTypesController::class, 'edit'])->name('admin.sales_material.edit');
    Route::put('/sales/update/{id}', [SalesMaterialTypesController::class, 'update'])->name('admin.sales_material.update');
    Route::delete('/sales/delete/{id}', [SalesMaterialTypesController::class, 'delete'])->name('admin.sales_material.delete');



});


Route::group([
    'namespace' => 'admin',
    'prefix' => 'admin',
    'middleware' => 'guest:admin'
], function () {

    Route::get('login', [LoginController::class, 'showLoginView'])->name('admin.showlogin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});
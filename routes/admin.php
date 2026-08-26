<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AccountTypesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminPanelSettingsController;
use App\Http\Controllers\Admin\AdminShiftsController;
use App\Http\Controllers\Admin\SalesMaterialTypesController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\TreasuriesController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CollectController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DelegateController as AdminDelegateController;
use App\Http\Controllers\Admin\ExchangeController;
use App\Http\Controllers\Admin\GeneralReturnOrdersController;
use App\Http\Controllers\Admin\GeneralReturnSalesOrders;
use App\Http\Controllers\Admin\ItemCardBalanceController;
use App\Http\Controllers\Admin\ItemCardController as AdminItemCardController;
use App\Http\Controllers\Admin\SalesBillsController;
use App\Http\Controllers\Admin\SupplierCategoriesController;
use App\Http\Controllers\Admin\SupplierOrdersController;
use App\Http\Controllers\Admin\SuppliersController;

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
    'prefix' => 'admin',
    'middleware' => 'auth:admin'
], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/adminpanelsettings/show', [AdminPanelSettingsController::class, 'index'])->name('admin.adminpanelsettings.index');
    Route::get('/adminpanelsettings/edit', [AdminPanelSettingsController::class, 'edit'])->name('admin.adminpanelsettings.edit');
    Route::post('/adminpanelsettings/update', [AdminPanelSettingsController::class, 'update'])->name('admin.adminpanelsettings.update');
    /* Start Treasuries Routes */

    Route::prefix('treasuries')
        ->name('admin.treasuries.')
        ->group(function () {

            Route::get('index', [TreasuriesController::class, 'index'])
                ->name('index');

            Route::get('create', [TreasuriesController::class, 'create'])
                ->name('create');

            Route::post('store', [TreasuriesController::class, 'store'])
                ->name('store');

            Route::get('edit/{id}', [TreasuriesController::class, 'edit'])
                ->name('edit');

            Route::put('update/{id}', [TreasuriesController::class, 'update'])
                ->name('update');

            Route::get('details/{id}', [TreasuriesController::class, 'details'])
                ->name('details');

            Route::delete('delete/{id}', [TreasuriesController::class, 'delete'])
                ->name('delete');

            Route::get('add_treasuries_branch/{id}', [TreasuriesController::class, 'add_treasuries_branch'])
                ->name('add_treasuries_branch');

            Route::post('store_treasuries_branch/{id}', [TreasuriesController::class, 'store_treasuries_branch'])
                ->name('store_treasuries_branch');
        });
    /*start Sales Material */

    Route::prefix('sales')
        ->name('admin.sales_material.')
        ->group(function () {

            Route::get('index', [SalesMaterialTypesController::class, 'index'])
                ->name('index');

            Route::get('create', [SalesMaterialTypesController::class, 'create'])
                ->name('create');

            Route::post('store', [SalesMaterialTypesController::class, 'store'])
                ->name('store');

            Route::get('edit/{id}', [SalesMaterialTypesController::class, 'edit'])
                ->name('edit');

            Route::put('update/{id}', [SalesMaterialTypesController::class, 'update'])
                ->name('update');

            Route::delete('delete/{id}', [SalesMaterialTypesController::class, 'delete'])
                ->name('delete');
        });
    /*start Stores */

    Route::prefix('store')
        ->name('admin.store.')
        ->group(function () {

            Route::get('index', [StoresController::class, 'index'])
                ->name('index');

            Route::get('create', [StoresController::class, 'create'])
                ->name('create');

            Route::post('store', [StoresController::class, 'store'])
                ->name('store');

            Route::get('edit/{id}', [StoresController::class, 'edit'])
                ->name('edit');

            Route::put('update/{id}', [StoresController::class, 'update'])
                ->name('update');

            Route::delete('delete/{id}', [StoresController::class, 'delete'])
                ->name('delete');
        });
    /* start unites */

    Route::resource('unit', UnitController::class);
    Route::post('/unit/filter', [UnitController::class, 'filter'])->name('unit.filter');

    /* start categories */
    Route::resource('category', CategoryController::class);

    /* start item card */
    Route::resource('itemcard', AdminItemCardController::class);

    //for account types

    Route::get('/accounttypes/index', [AccountTypesController::class, 'index'])->name('admin.accounttypes.index');

    /* start accounts */
    Route::resource('accounts', AccountsController::class);
    Route::post('/accounts/filter', [AccountsController::class, 'filter'])->name('accounts.filter');

    /* start customers */
    Route::resource('customers', CustomerController::class);

    /* start suppliers category */
    Route::resource('suppliers_category', SupplierCategoriesController::class);

    /* start suppliers */
    Route::resource('suppliers', SuppliersController::class);

    /* start delegates */
    Route::resource('delegate', AdminDelegateController::class);

    /* start supplier orders */
    Route::resource('supplier_orders', SupplierOrdersController::class);

    Route::prefix('supplier_orders')
        ->name('supplier_orders.')
        ->group(function () {

            Route::post('getUnits', [SupplierOrdersController::class, 'getUnits'])
                ->name('getUnits');

            Route::post('addunits', [SupplierOrdersController::class, 'addUnits'])
                ->name('addunits');

            Route::delete('destroy_details/{id}', [SupplierOrdersController::class, 'destroyDetails'])
                ->name('destroy_details');

            Route::post('edititem', [SupplierOrdersController::class, 'editItem'])
                ->name('edititem');

            Route::post('update_item', [SupplierOrdersController::class, 'updateItem'])
                ->name('update_item');

            Route::post('model_approve', [SupplierOrdersController::class, 'modelApprove'])
                ->name('model_approve');
        });

    /* admin */
    Route::resource('admin_accounts', AdminController::class);
    Route::post('admin_treasuries', [AdminController::class, 'add_treasuries'])->name('admin_treasuries.addtreasuries');
    Route::delete('admin_treasuries/{id}', [AdminController::class, 'delete_treasuries'])->name('admin_treasuries.deletetreasuries');

    //admin shifts

    Route::resource('admin_shifts', AdminShiftsController::class);

    //collect transaction

    Route::resource('collect_transaction', CollectController::class);

    //exchange transaction

    Route::resource('exchange_transaction', ExchangeController::class);

    //sales bills

    Route::get('sales_item/mirrorGetUnits', [SalesBillsController::class, 'mirrorGetUnits'])->name('sales_item.mirrorgetUnits');
    Route::get('sales_item/mirror_get_batchs', [SalesBillsController::class, 'mirror_get_batchs'])->name('sales_item.mirror_get_batchs');

    //////////////////////////////////////////////////////////////////////////////////

    Route::resource('sales_bills', SalesBillsController::class);

    Route::get('sales_bills/print/{auto_serial}', [SalesBillsController::class, 'print'])->name('sales_bills.print');

    Route::prefix('sales_item')
        ->name('sales_item.')
        ->group(function () {

            Route::get('getUnits', [SalesBillsController::class, 'getUnits'])
                ->name('getUnits');

            Route::get('get_batchs', [SalesBillsController::class, 'get_batchs'])
                ->name('get_batchs');

            Route::get('get_price', [SalesBillsController::class, 'get_price'])
                ->name('get_price');

            Route::get('get_add_items', [SalesBillsController::class, 'get_add_items'])
                ->name('get_add_items');

            Route::post('open_active_bill', [SalesBillsController::class, 'open_active_bill'])
                ->name('open_active_bill');

            Route::post('save_active_billitems', [SalesBillsController::class, 'save_active_billitems'])
                ->name('save_active_billitems');

            Route::get('get_active_bill_data', [SalesBillsController::class, 'get_active_bill_data'])
                ->name('get_active_bill_data');

            Route::post('active_add_items', [SalesBillsController::class, 'active_add_items'])
                ->name('active_add_items');

            Route::delete('delete_item', [SalesBillsController::class, 'delete_item'])
                ->name('delete_item');

            Route::delete('active_delete_all_items', [SalesBillsController::class, 'active_delete_all_items'])
                ->name('active_delete_all_items');

            Route::post('approve_active_bill', [SalesBillsController::class, 'approve_active_bill'])
                ->name('approve_active_bill');
        });

    //general return orders

    Route::resource('general_return_orders', GeneralReturnOrdersController::class);

    Route::prefix('general_return_orders')
        ->name('general_return_orders.')
        ->group(function () {

            Route::get('get_batchs', [GeneralReturnOrdersController::class, 'getbatchs'])
                ->name('get_batchs');

            Route::post('getUnits', [GeneralReturnOrdersController::class, 'getUnits'])
                ->name('getUnits');

            Route::post('addunits', [GeneralReturnOrdersController::class, 'addUnits'])
                ->name('addunits');

            Route::delete('destroy_details/{id}', [GeneralReturnOrdersController::class, 'destroyDetails'])
                ->name('destroy_details');

            Route::post('edititem', [GeneralReturnOrdersController::class, 'editItem'])
                ->name('edititem');

            Route::post('update_item', [GeneralReturnOrdersController::class, 'updateItem'])
                ->name('update_item');

            Route::post('model_approve', [GeneralReturnOrdersController::class, 'modelApprove'])
                ->name('model_approve');
        });


    /* items details */
    Route::get('itemCardBalance/filter', [ItemCardBalanceController::class, 'filter'])->name('itemCardBalance.filter');
    Route::resource('itemCardBalance', ItemCardBalanceController::class);

    /* return sales orders */

    Route::prefix('general_return_sales_order')
        ->name('general_return_sales_order.')
        ->group(function () {

            Route::get('getUnits', [GeneralReturnSalesOrders::class, 'getUnits'])
                ->name('getUnits');

            Route::get('get_add_items', [GeneralReturnSalesOrders::class, 'get_add_items'])
                ->name('get_add_items');

            Route::post('open_active_bill', [GeneralReturnSalesOrders::class, 'open_active_bill'])
                ->name('open_active_bill');

            Route::post('save_active_billitems', [GeneralReturnSalesOrders::class, 'save_active_billitems'])
                ->name('save_active_billitems');

            Route::get('get_active_bill_data', [GeneralReturnSalesOrders::class, 'get_active_bill_data'])
                ->name('get_active_bill_data');

            Route::post('active_add_items', [GeneralReturnSalesOrders::class, 'active_add_items'])
                ->name('active_add_items');

            Route::delete('delete_item', [GeneralReturnSalesOrders::class, 'delete_item'])
                ->name('delete_item');

            Route::delete('active_delete_all_items', [GeneralReturnSalesOrders::class, 'active_delete_all_items'])
                ->name('active_delete_all_items');

            Route::post('approve_active_bill', [GeneralReturnSalesOrders::class, 'approve_active_bill'])
                ->name('approve_active_bill');
        });
    Route::resource('general_return_sales_order', GeneralReturnSalesOrders::class);
});

Route::get('/lang/{locale}', function ($locale) {

    if (! in_array($locale, ['en', 'ar'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return back();
})->name('lang.switch');


Route::group([
    'namespace' => 'admin',
    'prefix' => 'admin',
    'middleware' => 'guest:admin'
], function () {

    Route::get('login', [LoginController::class, 'showLoginView'])->name('admin.showlogin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});
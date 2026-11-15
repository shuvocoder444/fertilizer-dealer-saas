<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dealer\DealerOperationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/features', function () {
    return view('pages.features');
})->name('features');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/pricing', function () {
    return view('pages.pricing');
})->name('pricing');


// Authenticated Application Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Main Role-Aware Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // -------------------------------------------------------------------------
    // 1. Super Admin (Platform Owner)
    // -------------------------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dealers', [AdminController::class, 'dealers'])->name('dealers.index');
        Route::post('/dealers', [AdminController::class, 'storeDealer'])->name('dealers.store');
        Route::post('/dealers/{id}/status', [AdminController::class, 'updateDealerStatus'])->name('dealers.status');

        Route::get('/managers', [AdminController::class, 'managers'])->name('managers.index');

        Route::get('/plans', [AdminController::class, 'plans'])->name('plans.index');
        Route::post('/plans', [AdminController::class, 'storePlan'])->name('plans.store');

        Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');

        Route::get('/renewals', [AdminController::class, 'renewals'])->name('renewals.index');
        Route::post('/renewals/{id}/extend', [AdminController::class, 'extendRenewal'])->name('renewals.extend');

        Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets.index');
        Route::post('/tickets/{id}/reply', [AdminController::class, 'replyTicket'])->name('tickets.reply');

        Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements.index');
        Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');

        Route::get('/logs', [AdminController::class, 'logs'])->name('logs.index');

        Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });

    // -------------------------------------------------------------------------
    // 2. Dealer / Tenant Admin Operations
    // -------------------------------------------------------------------------
    Route::prefix('dealer')->name('dealer.')->group(function () {
        Route::get('/outlets', [DealerOperationsController::class, 'outlets'])->name('outlets.index');
        Route::post('/outlets', [DealerOperationsController::class, 'storeOutlet'])->name('outlets.store');

        Route::get('/managers', [DealerOperationsController::class, 'managers'])->name('managers.index');

        Route::get('/products', [DealerOperationsController::class, 'products'])->name('products.index');
        Route::post('/products', [DealerOperationsController::class, 'storeProduct'])->name('products.store');
        Route::post('/products/{id}/stock', [DealerOperationsController::class, 'updateStock'])->name('products.stock');

        Route::get('/purchases', [DealerOperationsController::class, 'purchases'])->name('purchases.index');
        Route::post('/purchases', [DealerOperationsController::class, 'storePurchase'])->name('purchases.store');

        Route::get('/sales', [DealerOperationsController::class, 'sales'])->name('sales.index');
        Route::post('/sales', [DealerOperationsController::class, 'storeSale'])->name('sales.store');

        Route::get('/customers', [DealerOperationsController::class, 'customers'])->name('customers.index');
        Route::post('/customers', [DealerOperationsController::class, 'storeCustomer'])->name('customers.store');
        Route::get('/customers/{id}', [DealerOperationsController::class, 'showCustomer'])->name('customers.show');
        Route::delete('/customers/{id}', [DealerOperationsController::class, 'destroyCustomer'])->name('customers.destroy');

        Route::get('/dues', [DealerOperationsController::class, 'dues'])->name('dues.index');
        Route::post('/dues/collect', [DealerOperationsController::class, 'collectDue'])->name('dues.collect');

        Route::get('/orders', [DealerOperationsController::class, 'orders'])->name('orders.index');

        Route::get('/reports', [DealerOperationsController::class, 'reports'])->name('reports.index');

        Route::get('/staff', [DealerOperationsController::class, 'staff'])->name('staff.index');

        Route::get('/subscription', [DealerOperationsController::class, 'subscription'])->name('subscription.index');
    });

});

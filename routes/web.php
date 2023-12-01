<?php

use App\Http\Controllers\Admin\CallTradeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth', '\Spatie\Permission\Middleware\RoleMiddleware:admin']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {


    // dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // User Profile
    Route::get('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'update_password'])->name('profile.update_password');


    // CUSTOMER ROUTES
    Route::get('customers', [CustomerController::class, 'customers'])->name('customers');
    Route::get('customers-view/{customer?}', [CustomerController::class, 'view'])->name('customer.view');

    Route::get('customers-statistics/{customer?}', [CustomerController::class, 'statistics'])->name('customer.statistics');


    Route::get('customers-add', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customers-add', [CustomerController::class, 'store'])->name('customer.store');

    Route::get('customers-edit/{customer?}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customers-update/{customer?}', [CustomerController::class, 'update'])->name('customer.update');

    Route::get('customers-delete/{customer?}', [CustomerController::class, 'destroy'])->name('customer.delete');

    Route::get('customers-statusUpdate/{status?}', [CustomerController::class, 'customerUpdateStatus'])->name('customer.updateStatus');

    Route::get('active-customers', [CustomerController::class, 'activeCustomers'])->name('customer.activeCustomers');

    Route::get('/get-total-commition', [CustomerController::class, 'getTotalCommition'])->name('customer.getTotalCommition');

    Route::get('/get-total-commition-date-range', [CustomerController::class, 'getTotalCommitionDateRange'])->name('customer.getTotalCommitionDateRange');

    //CALL TRADE
    Route::get('/callTrade', [CallTradeController::class,'callTrade'])->name('callTrades');
    Route::get('/callTrade-view/{id?}', [CallTradeController::class,'view'])->name('callTrade.view');

    Route::post('/callTrade-create', [CallTradeController::class,'createTradeNextBtn'])->name('callTrades.nextBtn');
    Route::post('callTrade-store',[CallTradeController::class,'storeTrade'])->name('callTrades.storeTrade');

    Route::get('callTrade-edit/{callTrade?}',[CallTradeController::class,'edit'])->name('callTrades.edit');
    Route::post('callTrade-update/{callTrade?}',[CallTradeController::class,'update'])->name('callTrades.update');

    Route::get('callTrade-delete/{callTrade?}', [CallTradeController::class, 'destroy'])->name('callTrades.delete');

    Route::get('callTrade-status/{status?}', [CallTradeController::class, 'updateStatus'])->name('callTrades.updateStatus');

});


// Route::middleware(['auth', 'role:admin'])->group(function () {
// });

require __DIR__ . '/auth.php';

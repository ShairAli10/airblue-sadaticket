<?php

use App\Http\Controllers\Front\Customer\AuthController;
use App\Http\Controllers\Front\CustomerPanelController;
use App\Http\Controllers\Front\Flight\CheckoutController;
use App\Http\Controllers\Front\Flight\FlightController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use Illuminate\Support\Facades\Route;


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

Route::controller(FrontHomeController::class)->group(function () {
    // Route::get('/', 'index')->name('home');
    Route::get('/home', 'index')->name('home');
});
Route::controller(FlightController::class)->group(function () {
    Route::get('/searchResult', 'searchResult')->name('flight.search');
    Route::get('/availability', 'availability')->name('flight.availability');
    Route::post('/flight-detail', 'flightDetail')->name('flight.detail.modal');
});
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'checkout')->name('checkout');
    Route::match(['post', 'get'], '/payment', 'payment')->name('payment');
    Route::post('/createpnr', 'createPnr')->name('create.pnr');
    Route::get('/thankyou/{id?}', 'thankyouPage')->name('thankyou.page');
});
Route::controller(CustomerPanelController::class)->middleware('auth')->group(function () {
    Route::get('my-bookings', 'myBookings')->name('mybookings');
    Route::get('my-profile', 'myProfile')->name('myprofile');
    Route::get('my-wallet', 'myWallet')->name('mywallet');
    Route::post('logout-customer', 'logoutCustomer')->name('logout.customer');
});
Route::controller(AuthController::class)->group(function () {
    Route::post('generate-otp', 'generateOtp')->name('otp.customer');
    Route::post('login-customer', 'loginCustomer')->name('login.customer');
    Route::post('signup-customer', 'signupCustomer')->name('signup.customer');
    Route::get('/verify/{token}', 'verifyEmail')->name('verify.email');
});

Auth::routes();



require_once __DIR__ . '/admin.php';

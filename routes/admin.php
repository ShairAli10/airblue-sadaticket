<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Booking\BookingController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\Customer\CustomerPricingEngineController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Flight\AdminFlightController;
use App\Http\Controllers\Admin\Flight\CheckoutController;
use App\Http\Controllers\Admin\PopularTourController;
use App\Http\Controllers\Admin\PricingEngine\AgentPricingEngineController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TravelAgentController;
use App\Http\Controllers\Front\Flight\FlightController;
use App\Http\Controllers\Admin\Why_choose_usController;
use App\Http\Controllers\Admin\DestinationController;

use App\Http\Controllers\PopularTours;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin');
Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('admin');
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/otp/{refkey?}', [AuthController::class, 'getOtp'])->name('admin.otp');
Route::post('/admin/otp-submit', [AuthController::class, 'submitOtp'])->name('admin.otp.submit');
Route::get('/admin/reset-password/{refkey?}', [AuthController::class, 'resetPassword'])->name('admin.reset.password');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('admin.resendOtp');
Route::post('/admin/reset-password-submit', [AuthController::class, 'resetPasswordSubmit'])->name('admin.reset.password.submit');
Route::get('/admin/forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.forgot.password');
Route::post('/admin/forgot-password-submit', [AuthController::class, 'forgotPasswordSubmit'])->name('admin.forgot.password.submit');

Route::group(['middleware'=>'admin','prefix' => 'admin', 'as'=>'admin.'],function(){
    Route::get('/logout',[DashboardController::class,'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/recent-booking', [DashboardController::class, 'bookingByStatus'])->name('dashboard.recent.booking');
    // Route::get('/admin/home', [DashboardController::class, 'index'])->name('admin.home');
    // Route::get('/users', [UserController::class, 'userList'])->name('users')->middleware(['permission:Delete Users']);

    Route::controller(AuthController::class)->group(function () {
        Route::get('/users-profile','userProfile')->name('users.profile');
        Route::post('/update-profile-image','userProfileUpdateImage')->name('users.profile.image.update');
        Route::post('/update-bio','updateBio')->name('users.bio.update');
        Route::get('/check-pasword','checkOldPassword')->name('users.check.oldPassword');
        Route::post('/change-pasword','changePassword')->name('users.change.password');
    });
    //**********************Admin Users******************************
    Route::controller(UserController::class)->group(function () {
        Route::get('/users','userList')->name('users');
        Route::post('/create-user','createUser')->name('user.create');
        Route::get('/delete-user/{user_id}','deleteUser')->name('user.delete');
        Route::get('/view-user/{admin_user}','viewUser')->name('user.view');
    });
    //**********************Travel Agents******************************
    Route::controller(TravelAgentController::class)->group(function () {
        Route::get('/agents','listAgent')->name('agent');
        Route::post('/create-agent','createAgent')->name('agent.create');
        Route::get('/view-agent/{admin_user}','viewAgent')->name('agent.view');
        Route::get('/delete-agent/{agent_id}','deleteAgent')->name('agent.delete');
    });

    //**********************Customer Users******************************
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer','index')->name('customer');
        Route::post('/create-customer','createCustomer')->name('customer.create');
        Route::get('/delete-customer/{customer}','deleteCustomer')->name('customer.delete');
        Route::get('/customer-detail/{customer}','viewCustomer')->name('customer.view');
        Route::post('/customer-update','updateCustomer')->name('customer.update');
    });
    //************Admin Agent Pricing Engine Routes*******************
    Route::controller(CustomerPricingEngineController::class)->group(function(){
        Route::get('/customer/pricing-engine/list','index')->name('customer.pricingEngine.list');
        Route::post('/customer/pricing-engine/store','store')->name('customer.pricingEngine.store');
        Route::get('/customer/pricing-engine/edit/{rule}','edit')->name('customer.pricingEngine.edit');
        Route::post('/customer/pricing-engine/update','update')->name('customer.pricingEngine.update');
        Route::get('/customer/pricing-engine/delete/{rule_id}','delete')->name('customer.pricingEngine.delete');
    });
    
    //************Admin Agent Pricing Engine Routes*******************
    Route::controller(AgentPricingEngineController::class)->group(function(){
        Route::get('/pricing-engine/list','index')->name('pricingEngine.list');
        Route::post('/pricing-engine/store','store')->name('pricingEngine.store');
        Route::get('/pricing-engine/edit/{rule}','edit')->name('pricingEngine.edit');
        Route::post('/pricing-engine/update','update')->name('pricingEngine.update');
        Route::get('/pricing-engine/delete/{rule_id}','delete')->name('pricingEngine.delete');
    });
    //******************User Group Routes*****************************
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/roles','roleList')->name('roles');
        Route::get('/create-role','createRole')->name('roles.create');
        Route::get('/delete-role/{role_id}','deleteRole')->name('roles.delete');
        Route::post('/edit-role','editRole')->name('roles.edit');
        Route::post('/update-role','updateRole')->name('roles.update');
        // Route::get('/view-role/{admin_role}','viewUser')->name('roles.view');
    });
    //**********************Flight Routes******************************
    Route::controller(AdminFlightController::class)->group(function () {
        Route::get('/flight/search','searchFlight')->name('flight.search');
        Route::get('/flight/search-flight','searchAvailability')->name('flight.search.availability');
        Route::get('/flight/search-empty','emptypOldResponse')->name('flight.search.empty.search');
        Route::post('/flight/flight-detail','flightDetail')->name('flight.detail');
        Route::post('/get-customer-data','getCustomerData')->name('customer.data');
        Route::post('/flight/fare-rules','getFareRules')->name('flight.fare.rule');
        Route::post('/get-customer-data','getCustomerData')->name('customer.data');
    });
    //**********************Checkout Routes******************************
    Route::controller(CheckoutController::class)->group(function(){
        Route::post('/flight/checkout','flightCheckout')->name('flight.checkout');
        Route::post('/flight/pnr','createPnr')->name('flight.create.pnr');
        Route::get('/booking/{booking_ref}','booking')->name('create.booking');
        Route::post('/issue-ticket','issueTicket')->name('issue.ticket');
    });
    Route::controller(BookingController::class)->group(function(){
        Route::get('/bookings','bookingList')->name('bookings');
        Route::get('/booking/{booking_ref}','bookingDetail')->name('create.booking');
        Route::post('/cancel-booking','cancelBooking')->name('cancel.booking')->middleware(['auth:admin', 'permission:Cancell-PNR']);
        Route::post('/void-ticket','voidTicket')->name('void.ticket')->middleware(['auth:admin', 'permission:Void-PNR']);

        Route::post('/email-booking','emailBooking')->name('email.booking');
        Route::get('/pdf/{booking_ref}/{f}','bookingPDF')->name('generate.pdf');
    });
    //**********************Settings Routes******************************
    Route::controller(SettingController::class)->group(function () {
        Route::get('/setting','index')->name('setting')->middleware(['auth:admin', 'permission:Read-Settings']);
        Route::post('/setting/store-airline-discount','storeAirlineDiscount')->name('setting.store.discount')->middleware(['auth:admin', 'permission:Read-Settings']);
        Route::post('/setting/update-airline-discount','updateAirlineDiscount')->name('setting.update.discount')->middleware(['auth:admin', 'permission:Read-Settings']);
        Route::post('/setting/update-procider-status','changeProviderStatus')->name('setting.update.status')->middleware(['auth:admin', 'permission:Read-Settings']);
        Route::post('/setting/delete-airline-discount','deleteAirlineDiscount')->name('setting.delete.discount')->middleware(['auth:admin', 'permission:Read-Settings']);
        Route::get('/setting/provider/{provider}','ProviderDetail')->name('provider')->middleware(['auth:admin', 'permission:Read-Settings']);
        Route::post('/setting/store-exclude-airline/','StoreExcludeAirline')->name('provider.exclude.airline')->middleware(['auth:admin', 'permission:Read-Settings']);
        // Route::get('/setting','smtp')->name('setting.smtp');
        Route::get('/setting/smtp/edit/{smtp}','editSmtp')->name('setting.smtp.edit');
        Route::post('/setting/smtp/update','updateSmtp')->name('setting.smtp.update');
    });
    //**********************Travel Agents******************************
    Route::controller(PopularTourController::class)->group(function () {
        Route::get('/tours','TourList')->name('tour.list');
        Route::post('/tours-save','TourSave');
        Route::get('/tours-show','TourList');
        Route::post('tours-update','TourUpdate');
        Route::post('tours-store','TourStore');
        Route::get('tours-delete/{tours}','TourDelete');
    });

    Route::controller(DestinationController::class)->group(function () {
        Route::get('/destination','DestList');
        Route::post('/destination-save','DestSave');
        Route::get('/destination-show','DestList');
        Route::post('destination-update','DestUpdate');
        Route::post('destination-store','DestStore');
        Route::get('destination-delete/{top}','DestDelete');
    });

    Route::controller(Why_choose_usController::class)->group(function() {
        Route::get('/why-choose-us','ChooseList');
        Route::post('/choose-save','ChooseSave');
        Route::get('/choose-show','ChooseList');
        Route::post('choose-update','ChooseUpdate');
        Route::post('choose-store','ChooseStore');
        Route::get('choose-delete/{choose}','ChooseDelete');
    });
 
    
});
/****************************************************\
 *              Front End Routes                   * |
\****************************************************/
Route::controller(AdminFlightController::class)->group(function(){
    Route::get('getAllAirPortCodes/{q?}','getAllAirPorts')->name('getAllAirPorts');
});
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');

    return "cache cleared...";
});

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPanelController extends Controller
{
    public function myBookings(){
        $bookings = Order::select('status','final_data','paid','created_at')
                    ->where('customerEmail',auth()->user()->email)
                    ->get();
        // dd($bookings);
        return view('front.customer-panel.my-bookings',compact('bookings'));
    }
    public function myProfile(){
        return view('front.customer-panel.my-profile');
    }
    public function myWallet(){
        return view('front.customer-panel.wallet');
    }

    // Logout the customer
    public function logoutCustomer()
    {
        Auth::logout();

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Front\Flight;

use App\Http\Controllers\Controller;
use App\Models\ApiOffer;
use Illuminate\Http\Request;
use App\Http\Traits\SabreTrait as Sabre;
use App\Mail\BookingMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $ref_key = $request->reference;
        $api_offer = ApiOffer::where('ref_key', $ref_key)->first();
        $data = $api_offer->finaldata;
        $result = $data;
        $query = json_decode($api_offer->query, true);
        return view('front.flight.checkout', compact('result', 'query', 'ref_key'));
    }
    public function payment(Request $request)
    {
        // return $request->all();
        $ref_key = $request->ref_key;
        $api_offer = ApiOffer::find(decrypt($request->ref_key));
        $data = $api_offer->finaldata;
        $result = $data;
        // Validation rules for signup
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:12|min:11|unique:users,phone',
            // 'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:12|min:11',
            'email' => 'required|email',
            'passengers' => 'required|array', // Ensure passengers is an array
            'passengers.*.passenger_title' => 'required|string|max:255',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.sur_name' => 'required|string|max:255',
            'passengers.*.dob' => 'required|date',
            'passengers.*.passenger_gender' => 'required|in:M,F', // Assuming gender is either M or F
            'passengers.*.nationality' => 'required|string|max:255',
            'passengers.*.document_number' => 'required|string|max:255',
            'passengers.*.document_expiry_date' => 'required|date',
            'passengers.*.passenger_type' => 'required|string|max:255',
            'passengers.*.document_type' => 'required|string|max:255',
        ];
        
        // Validate the request
        $request->validate($rules);

        $already_order = Order::where('CustomerEmail', $request->email)->wherePaid('Unpaid')->first();
        if (!$already_order) {
            Session::put($ref_key, $request->all());
            return view('front.flight.payment', compact('ref_key', 'result'));
        } else {
            return redirect()->back()->with('message', 'Please first pay your previous booking then book your next flight.');
        }
    }
    public function createPnr(Request $request)
    {
        $customers = Session::get($request->ref_key);
        $homePhone = $customers['phone'];
        $email = $customers['email'];

        $api_offer = ApiOffer::find(decrypt($request->ref_key));
        $fareData = $api_offer->data;
        $finalData = $api_offer->finaldata;
        
        $total_price = $finalData['Fares']['TotalPrice'];
        
        $results = Sabre::createPNR($customers, $fareData);
        if($results['status'] == 200){
            $booking = Order::create([
                'type' => 'flight',
                'api' =>  'Sabre',
                'pnrCode' => $results['pnr'],
                'user_id' => @auth()->user()->id,
                'customerEmail' => $email,
                'customerPhone' => $homePhone,
                'total' => $total_price,
                'pricingEnginePrice' => $total_price,
                'basePrice' => $total_price,
                'customPrice' => $total_price,
                'userPricingEnginePrice' => $total_price,
                'paid' => 'Unpaid',
                'apiResponse' => json_encode($results['response']),
                'final_data' => json_encode($finalData),
                'status' => 'Booked',
                'customer_data' => json_encode($customers),
                'customer_type' => 'customer',
            ]);
        }
        
        /****************** Email Booking ****************/
        
        $data = [
            'total_price' => $total_price,
            'siteUrl' => url('/'),
            'results' => $results,
            'customers' => $customers,
            'finalData' => $finalData
        ];
        $bookMail = new BookingMail($data);
        $bookMail->with($data);
        Mail::to($email)->send($bookMail);
        /**************** End Email Booking **************/

        Session::forget($request->ref_key);
        if (!$booking) {
            return redirect()->back()->with('message', 'something went wrong, please try again after some time Thanks');
        }
        return redirect()->route('thankyou.page', encrypt($booking->id));
        
    }
    public function thankyouPage($id)
    {
        $order = Order::find(decrypt($id));
        // return $order;
        return view('front.flight.thankyou', compact('order'));
    }
}

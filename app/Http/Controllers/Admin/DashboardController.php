<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AuthEmail;
use App\Mail\WelcomeEmail;
use App\Models\Order;
use App\Models\RecentSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index() {
        $orderQuery = Order::query();
    
        if (auth('admin')->user()->type == 'Travel Agent') {
            $orderQuery->where('user_id', auth('admin')->user()->id);
        }
    
        $recent_bookings = $orderQuery->select('ref_key', 'pnrCode', 'api', 'status', 'pnr_status', 'agency_id', 'user_id', 'final_data', 'created_at', 'issued_at')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
    
        $statuses = ['Not Ticketed', 'Ticketed', 'Voided', 'Cancelled', 'Refunded/Exchanged', 'Expired'];
        
        $data = Order::selectRaw("status, SUM(userPricingEnginePrice) as revenue, COUNT(*) as count")
            ->whereIn('status', $statuses)
            ->when(auth('admin')->user()->type === 'Travel Agent', function ($query) {
                return $query->where('user_id', auth('admin')->user()->id);
            })
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => ['revenue' => round($item->revenue), 'count' => $item->count]];
            })
            ->toArray();
    
        // Top recent searches
        $totalSearches = RecentSearch::count();
        $top_5_formatted = RecentSearch::selectRaw("CONCAT(origin, '-', destination) as route, COUNT(*) as count")
            ->groupBy('route')
            ->orderByDesc('count')
            ->limit(12)
            ->get()
            ->mapWithKeys(function ($search) use ($totalSearches) {
                return [
                    $search->route => (int) round(($search->count / $totalSearches) * 100)
                ];
            })
            ->filter(function ($percentage) {
                return $percentage > 0;
            })
            ->toArray();
    
        return view('admin.dashboard.dashboard', compact('data', 'top_5_formatted', 'recent_bookings'));
    } 
    public function index1(){
        $order = Order::query();
        if (auth('admin')->user()->type == 'Travel Agent') {
            $order->where('agency_id', auth('admin')->user()->travel_agency_id);
        }
        $bookings = $order->get();
        $recent_bookings = $order->select('ref_key','pnrCode','api','status','pnr_status','agency_id','user_id','final_data','created_at','issued_at')
                ->orderBy('id', 'desc')
                ->get()->take(10);
        
        /*****************Revenue**************************/
        $data = [
            'Not Ticketed' => ['revenue' => 0, 'count' => 0],
            'Ticketed' => ['revenue' => 0, 'count' => 0],
            'Voided' => ['revenue' => 0, 'count' => 0],
            'Cancelled' => ['revenue' => 0, 'count' => 0],
            'Refunded/Exchanged' => ['revenue' => 0, 'count' => 0],
            'Expired' => ['revenue' => 0, 'count' => 0]
        ];
        
        foreach ($bookings as $value) {
            $status = $value['status'];
            $data[$status]['revenue'] += round($value['userPricingEnginePrice']);
            $data[$status]['count']++;
        }
        /*****************Recent Searches*********************/
        $top_5_formatted = RecentSearch::selectRaw("CONCAT(origin, '-', destination) as route, COUNT(*) as count")
        ->groupBy('route')
        ->orderByDesc('count')
        ->limit(12)
        ->get()
        ->mapWithKeys(function ($search) {
            return [
                $search->route => (int) round(($search->count / RecentSearch::count()) * 100)
            ];
        })
        ->filter(function ($percentage) {
            return $percentage > 0;
        })
        ->toArray();
        /*****************Recent Searches*********************/
        return view('admin.dashboard.dashboard', compact('data','top_5_formatted','recent_bookings'));
    }
    public function bookingByStatus(Request $request){
        $order = Order::query();
        if (auth('admin')->user()->type == 'Travel Agent') {
            $order->where('agency_id', auth('admin')->user()->travel_agency_id);
        }
        $recent_bookings = $order->select('ref_key','pnrCode','api','status','pnr_status','agency_id','user_id','final_data','created_at','issued_at')
                ->orderBy('id', 'desc')
                ->where('status',$request->status)
                ->get()->take(10);
        $html = view('admin.dashboard.includes.recent-booking',compact('recent_bookings'))->render();
        return json_encode(['message' => 'success', 'html' => $html]);
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function logoutOnTabClose(Request $request){
        Auth::guard('admin')->logout();
        return response()->json(['status' => 'Logged out']);
    }
    
}

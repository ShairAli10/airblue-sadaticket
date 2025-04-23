<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\PopularTour;
use App\Models\why_choose_us;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $choose = why_choose_us::get();
        $tours = PopularTour::get();
        $top = Destination::get();
        return view('front.home',compact('choose','tours','top'));
    }
}

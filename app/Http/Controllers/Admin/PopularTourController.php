<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PopularTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PopularTourController extends Controller
{
    public function TourList(){
        $tours = PopularTour::get();
        return view('admin.tours.list',compact('tours'));
    }

    public function TourSave(Request $request){
        $banner_image = time().'.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('Tours'),$banner_image);
        $tours = new PopularTour;
        $tours->banner_image = $banner_image;
        $tours->Title = $request->title;
        $tours->status =   $request->status;
        $tours->price = $request->price;
        $tours->save();
        return back()->withSuccess('Uploaded');  
    }

    public function TourUpdate(Request $request)
    {
        $tours = PopularTour::find($request->id);
        if (isset($request->banner_image)){
            $banner_image = time().'.'.$request->banner_image->extension();
            $request->banner_image->move(public_path('Tours'),$banner_image);
            $tours->Banner_Image = $banner_image;
        }
        $tours->Title = $request->title;
        $tours->Status = $request->status;
        $tours->Price = $request->price;

        if($tours->save()){
            return back()->withSuccess('Updated'); 
        }else{
            return back()->withError('Not Uploaded'); 
        }
        
    }

    public function TourStore(Request $request)
    {
        $tours = PopularTour::updateOrCreate(
            ['id'=>$request->id],
            ['id'=>$request->Banner_Image],
            ['id'=>$request->Title],
            ['id'=>$request->Price],
            ['id'=>$request->Status],
            ['id'=>$request->Data],
        );
        return response()->json($tours);
    }

    public function TourDelete(PopularTour $tours)
    {
        $tours->delete();
        return redirect()->back()->withSuccess('Delete succsess');

    }
    
}

  
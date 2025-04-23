<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DestinationController extends Controller
{
   
    public function DestList(){
        $top = Destination::get();
        return view('admin.top.list',compact('top'));
    }

    public function DestSave(Request $request){
        // dd($request->all());
        $banner_image = time().'.'.$request->banner_image->extension();
        $request->banner_image->move(public_path('Top'),$banner_image);
        $top = new Destination;
        $top->banner_image = $banner_image;
        $top->title = $request->title;
        $top->from = $request->from;
        $top->to = $request->to;
        $top->status =   $request->status;
        $top->save();
        return back()->withSuccess('Uploaded');  
    }

    public function DestUpdate(Request $request)
    {
        $top = Destination::find($request->id);
        if (isset($request->banner_image)){
            $banner_image = time().'.'.$request->banner_image->extension();
            $request->banner_image->move(public_path('Top'),$banner_image);
            $top->banner_image = $banner_image;
        }
        $top->title = $request->title;
        $top->from = $request->from;
        $top->to = $request->to;
        $top->status = $request->status;
        if($top->save()){
            return back()->withSuccess('Updated'); 
        }else{
            return back()->withError('Not Uploaded'); 
        }
        
    }

    public function DestStore(Request $request)
    {
        $top = Destination::updateOrCreate(
            ['id'=>$request->id],
            ['id'=>$request->banner_image],
            ['id'=>$request->title],
            ['id'=>$request->from],
            ['id'=>$request->to],
            ['id'=>$request->Status],
            ['id'=>$request->Data],
        );
        return response()->json($top);
    }

    public function DestDelete(Destination $top)
    {
        $top->delete();
        return redirect()->back()->withSuccess('Delete succsess');

    }
}

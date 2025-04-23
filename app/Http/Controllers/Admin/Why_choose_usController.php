<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\why_choose_us;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class Why_choose_usController extends Controller
{
    public function ChooseList(){
        $choose = why_choose_us::get();
        return view('admin.choose.list',compact('choose'));
    }

    public function ChooseSave(Request $request){
        $icon = time().'.'.$request->icon->extension();
        $request->icon->move(public_path('Choose'),$icon);
        $choose = new why_choose_us;
        $choose->icon = $icon;
        $choose->title = $request->title;
        $choose->description =   $request->description;
        $choose->status = $request->status;
        $choose->save();
        return back()->withSuccess('Upload');  
    }

    public function ChooseUpdate(Request $request)
    {
        // dd($request->all());
        $choose = why_choose_us::find($request->id);
        if($request->icon){
            $icon = time().'.'.$request->icon->extension();
            $request->icon->move(public_path('Choose'),$icon);
            $choose->icon = $icon;
        }

        $choose->title = $request->title;
        $choose->description = $request->description;
        $choose->status = $request->status;
        if($choose->save()){
            return back()->withSuccess('Updated'); 
        }else{
            return back()->withError('Not Uploaded'); 
        }
        
    }

    public function ChooseStore(Request $request)
    {
        $choose = why_choose_us::updateOrCreate(
            ['id'=>$request->id],
            ['id'=>$request->icon],
            ['id'=>$request->title],
            ['id'=>$request->description],
            ['id'=>$request->Status],
            ['id'=>$request->Data],
        );
        return response()->json($choose);
    }
    public function ChooseDelete(why_choose_us $choose)
    {
        $choose->delete();
        return redirect()->back()->withSuccess('Delete succsess');

    }
}

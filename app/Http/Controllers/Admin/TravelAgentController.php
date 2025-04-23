<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class TravelAgentController extends Controller
{
    public function listAgent(){
        $roles = Role::orderBy('id','asc')->get()->pluck('name')->except(0);
        $admin_users = Admin::where('type','Travel Agent')->get();
        return view('admin.agents.list',compact('admin_users','roles'));
    }
    public function createAgent(Request $request){
        try {

            $role = Role::where('name',$request->role_name)->first();
            
            $admin = new Admin();
            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->type = 'Travel Agent';
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);

            $remember_token = Str::random(40);
            $admin->remember_token = $remember_token;
        
            $admin->save();
            if($admin)
                $admin->assignRole($role,);
            // ----------------Verifiction Admin user email------------------
            $data = [
                'first_name' => $admin->first_name,
                'last_name' => $admin->last_name,
                'url' => url("/admin/reset-password/{$remember_token}"),
            ];
            $welcome_email = new WelcomeEmail($data);
            $welcome_email->with($data);
            Mail::to($admin->email)->send($welcome_email);
            // ----------------Verifiction Admin user email------------------
                return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // Return an error response
            return response()->json(['error' => 'An error occurred. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }
    public function viewAgent(Admin $admin_user){
        $roles = Role::orderBy('id','asc')->get()->pluck('name')->except(0);
        return view('admin.agents.agent-detail',compact('admin_user','roles'));
    }
    public function deleteAgent(Admin $agent_id){
        if($agent_id->delete()){
          return  redirect()->back();
        }else{
            return 'not deleted';
        }
    }
}

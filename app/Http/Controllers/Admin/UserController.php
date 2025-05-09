<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function userList(){
        $roles = Role::orderBy('id','asc')->get()->pluck('name')->except(0);
        $admin_users = Admin::where('type','Admin User')->get();
        return view('admin.users.list',compact('admin_users','roles'));
        // $packages = Package::all();
        // return view('frontend.home',compact('packages'));
    }
    public function createUser(Request $request){
        try {

            $role = Role::where('name',$request->role_name)->first();
            
            $admin = new Admin();
            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->type = 'Admin User';
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
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }
    public function viewUser(Admin $admin_user){
        $roles = Role::orderBy('id','asc')->get()->pluck('name')->except(0);
        return view('admin.users.user-detail',compact('admin_user','roles'));
    }
    public function deleteUser(Admin $user_id){
        if($user_id->delete()){
          return  redirect()->back();
        }else{
            return 'not deleted';
        }
    }
}

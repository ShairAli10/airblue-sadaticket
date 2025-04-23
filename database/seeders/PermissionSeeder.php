<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(['id'=>1],['name' => 'Super Admin','guard_name'=> 'admin','user_type' => 'Admin']);

        $permission = Permission::updateOrCreate(['id'=>1],['module_name' => 'Flights', 'name' => 'Availability-Search','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>2],['module_name' => 'Flights', 'name' => 'Book-PNR','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>3],['module_name' => 'Flights', 'name' => 'Issue-PNR','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>4],['module_name' => 'Flights', 'name' => 'Cancell-PNR','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>5],['module_name' => 'Flights', 'name' => 'Void-PNR','guard_name'=> 'admin']);

        $permission = Permission::updateOrCreate(['id'=>6],['module_name' => 'Admin Users', 'name' => 'List-Users','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>7],['module_name' => 'Admin Users', 'name' => 'Add-Users','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>8],['module_name' => 'Admin Users', 'name' => 'Edit-Users','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>9],['module_name' => 'Admin Users', 'name' => 'Delete-Users','guard_name'=> 'admin']);
        
        // $permission = Permission::updateOrCreate(['id'=>10],['module_name' => 'Credit Limit', 'name' => 'List-Credit-Limit','guard_name'=> 'admin']);
        // $permission = Permission::updateOrCreate(['id'=>11],['module_name' => 'Credit Limit', 'name' => 'Add-Credit-Limit','guard_name'=> 'admin']);
        // $permission = Permission::updateOrCreate(['id'=>12],['module_name' => 'Credit Limit', 'name' => 'Update-Credit-Limit','guard_name'=> 'admin']);
        
        $permission = Permission::updateOrCreate(['id'=>10],['module_name' => 'OTA Customers', 'name' => 'List-Customers','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>11],['module_name' => 'OTA Customers', 'name' => 'Create-Customers','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>12],['module_name' => 'OTA Customers', 'name' => 'Detail-Customers','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>13],['module_name' => 'OTA Customers', 'name' => 'Update-Customers','guard_name'=> 'admin']);
        
        
        $permission = Permission::updateOrCreate(['id'=>14],['module_name' => 'Roles', 'name' => 'List-Of-Roles','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>15],['module_name' => 'Roles', 'name' => 'Create-Roles','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>16],['module_name' => 'Roles', 'name' => 'Edit-Roles','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>17],['module_name' => 'Roles', 'name' => 'Delete-Roles','guard_name'=> 'admin']);
        
        $permission = Permission::updateOrCreate(['id'=>18],['module_name' => 'Travel Agents', 'name' => 'List-Agents','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>19],['module_name' => 'Travel Agents', 'name' => 'Create-Agents','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>20],['module_name' => 'Travel Agents', 'name' => 'Edit-Agents','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>21],['module_name' => 'Travel Agents', 'name' => 'Update-Agents','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>22],['module_name' => 'Travel Agents', 'name' => 'Detail-Agents','guard_name'=> 'admin']);
        
        $permission = Permission::updateOrCreate(['id'=>23],['module_name' => 'Agent Pricing', 'name' => 'List-Agent-Pricing','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>24],['module_name' => 'Agent Pricing', 'name' => 'Create-Agent-Pricing','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>25],['module_name' => 'Agent Pricing', 'name' => 'Edit-Agent-Pricing','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>26],['module_name' => 'Agent Pricing', 'name' => 'Delete-Agent-Pricing','guard_name'=> 'admin']);
        
        $permission = Permission::updateOrCreate(['id'=>27],['module_name' => 'Customer Pricing', 'name' => 'List-Customer-Pricing','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>28],['module_name' => 'Customer Pricing', 'name' => 'Create-Customer-Pricing','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>29],['module_name' => 'Customer Pricing', 'name' => 'Edit-Customer-Pricing','guard_name'=> 'admin']);
        $permission = Permission::updateOrCreate(['id'=>30],['module_name' => 'Customer Pricing', 'name' => 'Delete-Customer-Pricing','guard_name'=> 'admin']);

        $permission = Permission::updateOrCreate(['id'=>100],['module_name' => 'Settings', 'name' => 'Read-Settings','guard_name'=> 'admin']);
        
        $permissions = Permission::where('guard_name','admin')->get();
        foreach($permissions as $permission){
            $role->givePermissionTo($permission);
        }
        $admin = Admin::first();
        $admin2 = Admin::find(2);
        $admin->assignRole($role,);
        $admin2->assignRole($role,);
    }
}

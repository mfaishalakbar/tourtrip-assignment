<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Define all permissions
        $permissionNames = [
            // Permissions for Cities
            'city:browse',
            'city:read',
            'city:edit',
            'city:add',
            'city:delete',

            // Permissions for Trips
            'trip:browse',
            'trip:read',
            'trip:edit',
            'trip:add',
            'trip:delete',

            // Permissions for Hotels
            'hotel:browse',
            'hotel:read',
            'hotel:edit',
            'hotel:add',
            'hotel:delete',

            // Permissions for Customer
            'customer:browse',
            'customer:read',
            'customer:edit',
            'customer:add',
            'customer:delete',

            // Permissions for Staff
            'staff:browse',
            'staff:read',
            'staff:edit',
            'staff:add',
            'staff:delete',

            // Permissions for Transaction
            'transaction:browse',
            'transaction:read',
            'transaction:edit',
            'transaction:add',
            'transaction:delete',
            'transaction:approve'
        ];

        // Define roles and access to it
        $roles = [
            'admin' => $permissionNames,
            'staff' => array_filter($permissionNames, function($var) {
                // Staff cannot modify or alter user
                return !\str_starts_with($var, "staff:");
            }),
            'customer' => [
                'city:browse',
                'city:read',
                'trip:browse',
                'trip:read',
                'hotel:browse',
                'hotel:read',
                'transaction:browse',
                'transaction:read',
                'transaction:add',
                'transaction:delete',
            ] // Default user can't do anything.
        ];

        // Create Super Admin User
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@tourtrip.id',
            'password' => Hash::make('admintourtrip'),
        ]);

        // Find newly created user
        $user = User::where('email', 'admin@tourtrip.id')->first();

        // Create Staff User
        DB::table('users')->insert([
            'name' => 'Staff',
            'email' => 'staff@tourtrip.id',
            'password' => Hash::make('stafftourtrip'),
        ]);

        // Find newly created staff
        $userStaff = User::where('email', 'staff@tourtrip.id')->first();

        // Create Staff
        $userStaffOut = DB::table('staffs')->insertGetId([
            'user_id' => $userStaff->id,
            'gender' => 'L',
        ]);
        $userStaff->staff_id = $userStaffOut;
        $userStaff->save();
    
        
        // Create Permissions
        foreach ($permissionNames as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles, and assign to permission
        foreach ($roles as $roleName => $rolePermission) {
            $newRole = Role::create(['name' => $roleName]);
            foreach ($rolePermission as $permission) {
                $_permission = Permission::where('name', '=', $permission)->first();
                $_permission->assignRole($newRole);
            }
        }
        
        // Finally, assign role
        $user->assignRole(Role::where('name', '=', 'admin')->first());
        $userStaff->assignRole(Role::where('name', '=', 'staff')->first());
    }
}

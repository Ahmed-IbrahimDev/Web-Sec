<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()["\Spatie\Permission\PermissionRegistrar"]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            ['name' => 'view_products', 'description' => 'Can view products'],
            ['name' => 'create_products', 'description' => 'Can create products'],
            ['name' => 'edit_products', 'description' => 'Can edit products'],
            ['name' => 'delete_products', 'description' => 'Can delete products'],
            ['name' => 'view_users', 'description' => 'Can view users'],
            ['name' => 'manage_users', 'description' => 'Can manage users'],
            ['name' => 'manage_roles', 'description' => 'Can manage roles and permissions'],
            ['name' => 'make_payments', 'description' => 'Can make payments'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(['name' => $permissionData['name']], $permissionData);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Employee with system access and management capabilities']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Employee with access to manage products and non-admin users']);
        $customerRole = Role::firstOrCreate(['name' => 'custmer'], ['description' => 'Custmer with access to view products and make purchases']);

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());

        $employeePermissions = [
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            'view_users',
            'manage_users',
        ];
        $employeeRole->syncPermissions($employeePermissions);

        $customerPermissions = [
            'view_products',
            'make_payments',
        ];
        $customerRole->syncPermissions($customerPermissions);

        // Create admin user
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $admin->assignRole($adminRole);
        }

        // Create employee user
        if (!User::where('email', 'employee@example.com')->exists()) {
            $employee = User::create([
                'name' => 'Employee User',
                'email' => 'employee@example.com',
                'password' => Hash::make('password'),
            ]);
            $employee->assignRole($employeeRole);
        }

        // Create customer user
        if (!User::where('email', 'customer@example.com')->exists()) {
            $customer = User::create([
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
            ]);
            $customer->assignRole($customerRole);
        }
    }
}
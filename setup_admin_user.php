<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

try {
    \Illuminate\Support\Facades\DB::beginTransaction();

    // 1. Create the 'admin' role if it doesn't exist
    $adminRole = \App\Models\Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator with permissions similar to an employee.']);

    // 2. Find the 'employee' role and sync its permissions to the 'admin' role
    $employeeRole = \App\Models\Role::where('name', 'employee')->with('permissions')->first();
    if ($employeeRole) {
        $permissionIds = $employeeRole->permissions->pluck('id');
        $adminRole->permissions()->sync($permissionIds);
        echo "'admin' role synced with 'employee' permissions.\n";
    } else {
        echo "Warning: 'employee' role not found. 'admin' role created without permissions.\n";
    }

    // 3. Find the superadmin user and update them
    $user = \App\Models\User::where('email', 'superadmin@example.com')->first();

    if ($user) {
        // Change email
        $user->email = 'admin@example.com';
        $user->save();

        // Detach 'super_admin' role and attach 'admin' role
        $superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $user->roles()->detach($superAdminRole->id);
        }
        $user->roles()->syncWithoutDetaching([$adminRole->id]);

        echo "User 'superadmin@example.com' updated to 'admin@example.com' with the 'admin' role.\n";
    } else {
        // If user doesn't exist, create it
        $adminUser = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'credit' => 1000.00
            ]
        );
        $adminUser->roles()->sync([$adminRole->id]);
        echo "User 'admin@example.com' created with the 'admin' role.\n";
    }

    \Illuminate\Support\Facades\DB::commit();
    echo "Script completed successfully.\n";

} catch (\Exception $e) {
    \Illuminate\Support\Facades\DB::rollBack();
    echo 'Error: ' . $e->getMessage() . "\n";
}

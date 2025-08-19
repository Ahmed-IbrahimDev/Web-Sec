<?php
// Bootstrap Laravel
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

try {
    // Use a transaction for safety
    \Illuminate\Support\Facades\DB::beginTransaction();

    // 1. Find or create the 'admin' role
    $adminRole = \App\Models\Role::firstOrCreate(
        ['name' => 'admin'],
        ['description' => 'Administrator with permissions similar to an employee.']
    );

    // 2. Find the 'employee' role to copy permissions from
    $employeeRole = \App\Models\Role::where('name', 'employee')->with('permissions')->first();
    if ($employeeRole) {
        $permissionIds = $employeeRole->permissions->pluck('id');
        $adminRole->permissions()->sync($permissionIds);
        echo "'admin' role created and synced with 'employee' permissions.\n";
    } else {
        echo "Warning: 'employee' role not found. 'admin' role created without permissions.\n";
    }

    // 3. Find the user with 'superadmin@example.com'
    $user = \App\Models\User::where('email', 'superadmin@example.com')->first();

    if ($user) {
        // Update email
        $user->email = 'admin@example.com';
        $user->save();

        // Find the 'super_admin' role to detach it
        $superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $user->roles()->detach($superAdminRole->id);
        }

        // Attach the new 'admin' role
        $user->roles()->attach($adminRole->id);

        echo "User 'superadmin@example.com' was updated to 'admin@example.com' and assigned the 'admin' role.\n";
    } else {
        // If 'superadmin@example.com' does not exist, check for 'admin@example.com' or create it
        $adminUser = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'credit' => 1000.00
            ]
        );
        $adminUser->roles()->sync([$adminRole->id]); // sync ensures only this role is attached
        echo "User 'admin@example.com' was found or created and assigned the 'admin' role.\n";
    }

    // Commit the transaction
    \Illuminate\Support\Facades\DB::commit();
    echo "Script completed successfully.\n";

} catch (\Exception $e) {
    // Rollback on error
    \Illuminate\Support\Facades\DB::rollBack();
    echo 'An error occurred: ' . $e->getMessage() . "\n";
}

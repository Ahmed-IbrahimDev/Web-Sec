<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('super_admin');
        $isAdmin = $user->hasRole('employee');
        $isOwner = $user->hasRole('owner');
        $isRegularUser = $user->hasRole('user');
        
        if ($isSuperAdmin || $isAdmin || $isOwner) {
            // Admin/Super Admin dashboard - full statistics
            // User statistics
            $totalUsers = User::count();
            $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();
            $activeUsers = User::where('updated_at', '>=', now()->subDays(7))->count();
            
            // Product statistics
            $totalProducts = Product::count();
            $newProducts = Product::where('created_at', '>=', now()->subDays(30))->count();
            $avgPrice = Product::avg('price');
            $outOfStockProducts = 0; // Assuming we don't have stock field yet
            
            // Role and permission statistics
            $totalRoles = Role::count();
            $totalPermissions = Permission::count();
            
            // Monthly user registrations for chart
            $monthlyUsers = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthStart = Carbon::create(date('Y'), $i, 1, 0, 0, 0);
                $monthEnd = $monthStart->copy()->endOfMonth();
                
                $monthlyUsers[$i] = User::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            }
            
            // Recent activities - last 10 products added
            $recentProducts = Product::orderBy('created_at', 'desc')->take(10)->get();
            
            // Get product categories (for demonstration, we'll simulate categories)
            $productCategories = [
                'Electronics' => $totalProducts * 0.3,
                'Clothing' => $totalProducts * 0.25,
                'Food' => $totalProducts * 0.2,
                'Books' => $totalProducts * 0.15,
                'Other' => $totalProducts * 0.1
            ];
            
            return view('dashboard', compact(
                'totalUsers', 
                'newUsers', 
                'activeUsers',
                'totalProducts', 
                'newProducts', 
                'avgPrice',
                'outOfStockProducts',
                'totalRoles',
                'totalPermissions',
                'monthlyUsers',
                'recentProducts',
                'productCategories',
                'isSuperAdmin',
                'isAdmin',
                'isOwner',
                'isRegularUser'
            ));
        } else {
            // Regular user dashboard - limited information
            $totalProducts = Product::count();
            $recentProducts = Product::orderBy('created_at', 'desc')->take(6)->get();
            
            return view('dashboard_modern', compact(
                'totalProducts',
                'recentProducts',
                'isSuperAdmin',
                'isAdmin',
                'isOwner',
                'isRegularUser'
            ));
        }
    }
}
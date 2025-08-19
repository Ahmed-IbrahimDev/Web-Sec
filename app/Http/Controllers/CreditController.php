<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CreditController extends Controller
{
    /**
     * Show credit management page for employees
     */
    public function index()
    {
        // Check if user is employee
        if (!Auth::user()->hasRole('employee')) {
            abort(403, 'Only employees can manage customer credit.');
        }
        
        // Get all custmer users
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'custmer');
        })->get();
        
        return view('credit-management', compact('customers'));
    }
    
    /**
     * Add credit to a customer's account
     */
    public function addCredit(Request $request)
    {
        // Check if user is employee
        if (!Auth::user()->hasRole('employee')) {
            abort(403, 'Only employees can manage customer credit.');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01|max:10000'
        ]);
        
        $customer = User::findOrFail($request->user_id);
        
        // Verify the user has custmer role
        if (!$customer->hasRole('custmer')) {
            return redirect()->back()->with('error', 'Credit can only be added to customers.');
        }
        
        // Add credit (only positive values allowed)
        if ($customer->addCredit($request->amount)) {
            return redirect()->back()->with('success', 
                "Successfully added {$request->amount} credit to {$customer->name}'s account. New balance: {$customer->credit}");
        }
        
        return redirect()->back()->with('error', 'Failed to add credit. Please try again.');
    }
    
    /**
     * Show customer list for employees
     */
    public function customerList()
    {
        // Check if user is employee
        if (!Auth::user()->hasRole('employee')) {
            abort(403, 'Only employees can view customer list.');
        }
        
        // Get all custmer users with their purchase history
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'custmer');
        })->withCount('boughtProducts')->get();
        
        return view('customer-list', compact('customers'));
    }
}

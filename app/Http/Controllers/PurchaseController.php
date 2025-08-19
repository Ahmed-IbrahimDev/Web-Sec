<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\BoughtProduct;
use App\Models\User;

class PurchaseController extends Controller
{
    /**
     * Buy a product
     */
    public function buyProduct(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);
        
        // Check if user has custmer role
        if (!$user->hasRole('custmer')) {
            return redirect()->back()->with('error', 'Only customers can purchase products.');
        }
        
        // Check if user has sufficient credit
        if (!$user->hasSufficientCredit($product->price)) {
            return view('insufficient-credit', [
                'product' => $product,
                'userCredit' => $user->credit,
                'requiredAmount' => $product->price
            ]);
        }
        
        // Deduct credit and record purchase
        if ($user->deductCredit($product->price)) {
            BoughtProduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'price_paid' => $product->price,
                'quantity' => 1
            ]);
            
            return redirect()->route('my-purchases')->with('success', 'Product purchased successfully!');
        }
        
        return redirect()->back()->with('error', 'Purchase failed. Please try again.');
    }
    
    /**
     * Show user's purchased products
     */
    public function myPurchases()
    {
        $user = Auth::user();
        $purchases = $user->boughtProducts()->with('product')->orderBy('created_at', 'desc')->get();
        
        return view('my-purchases', compact('purchases'));
    }
    
    /**
     * Show insufficient credit page
     */
    public function insufficientCredit(Product $product)
    {
        $user = Auth::user();
        return view('insufficient-credit', [
            'product' => $product,
            'userCredit' => $user->credit,
            'requiredAmount' => $product->price
        ]);
    }
}

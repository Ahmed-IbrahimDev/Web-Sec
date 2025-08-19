<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Check if the current user is an admin or owner.
     */
    private function checkAdminPermission()
    {
        if (!Auth::check() || (!Auth::user()->hasRole('employee') && !Auth::user()->hasRole('owner') && !Auth::user()->hasRole('super_admin') && !Auth::user()->hasRole('admin'))) {
            abort(403, 'Unauthorized. Only administrators can perform this action.');
        }
    }

    /**
     * Check if the current user is a super admin.
     */
    private function checkSuperAdminPermission()
    {
        if (!Auth::check() || !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Only super administrators can perform this action.');
        }
    }
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkAdminPermission();
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkAdminPermission();
        
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Sanitize inputs
        $name = filter_var($request->name, FILTER_SANITIZE_STRING);
        $description = filter_var($request->description, FILTER_SANITIZE_STRING);
        $price = filter_var($request->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Create product
        Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ]);

        return redirect()->route('products')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->checkAdminPermission();
        
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->checkAdminPermission();
        
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Sanitize inputs
        $name = filter_var($request->name, FILTER_SANITIZE_STRING);
        $description = filter_var($request->description, FILTER_SANITIZE_STRING);
        $price = filter_var($request->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Update product
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ]);

        return redirect()->route('products')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkAdminPermission();
        
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products')
            ->with('success', 'Product deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductApprovalLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('seller.products.create');
    }

    public function index()
    {
        $products = Product::where('seller_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('seller.products.index', compact('products'));
    }

    public function pending()
    {
        $products = Product::where('seller_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('seller.products.pending', compact('products'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'seller_id'   => auth()->id(),
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'quantity'    => $validated['quantity'],
            'image'       => $validated['image'] ?? null,
            'status'      => 'pending',
        ]);

        ProductApprovalLog::create([
            'product_id' => $product->id,
            'seller_id'  => auth()->id(),
            'status'     => 'pending',
        ]);

        return redirect()->back()->with('success', 'Product submitted for admin approval.');
    }

    public function buy(Product $product)
{
    // Here you’ll eventually redirect to Flutterwave payment
    return "Buy page for: ".$product->name;
}

}

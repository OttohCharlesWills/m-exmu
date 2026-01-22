<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductApprovalLog;
use Illuminate\Http\Request;

class ProductApprovalController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'pending')->with('seller')->get();

        return view('admin.products.pending', compact('products'));
    }

    public function approve(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'status' => 'approved',
        ]);

        ProductApprovalLog::create([
            'product_id'  => $product->id,
            'seller_id'   => $product->seller_id,
            'status'      => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_note'  => $request->admin_note,
        ]);

        return redirect()->back()->with('success', 'Product approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'status' => 'rejected',
        ]);

        ProductApprovalLog::create([
            'product_id'  => $product->id,
            'seller_id'   => $product->seller_id,
            'status'      => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_note'  => $request->admin_note,
        ]);

        return redirect()->back()->with('success', 'Product rejected.');
    }
}

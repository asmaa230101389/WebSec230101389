<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());
        return redirect('/products')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect('/products')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/products')->with('success', 'Product deleted successfully');
    }

    public function purchase(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();
        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return redirect('/products')->with('error', 'Not enough stock available.');
        }

        $totalPrice = $product->price * $quantity;
        if ($user->credit < $totalPrice) {
            return redirect('/products')->with('error', 'Insufficient credit.');
        }

        $user->credit -= $totalPrice;
        $user->save();

        $product->stock -= $quantity;
        $product->save();

        \App\Models\Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
        ]);

        return redirect('/products')->with('success', 'Purchase completed successfully');
    }
}
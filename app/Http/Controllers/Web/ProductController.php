<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function list(Request $request) {
        $products = Product::all();
        return view('products.list', compact('products'));
    }
}
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $purchases = Purchase::where('user_id', $user->id)->get();
    return view('purchases.index', compact('purchases'));
}
}
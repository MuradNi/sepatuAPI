<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItems;

class CartItemsController extends Controller
{
    public function index(Request $request){
        $query = CartItems::query();

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('cart_id')) {
            $query->where('cart_id', $request->cart_id);
        }

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('size_id')) {
            $query->where('size_id', $request->size_id);
        }

        if ($request->has('quantity')) {
            $query->where('quantity', $request->quantity);
        }
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }


        $get = $query->get();

        if ($get->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'value tidak ditemukan'], 404);
            }

        return response()->json($get);
    }
}

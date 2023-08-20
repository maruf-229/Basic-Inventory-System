<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, $id){
        $product = DB::table('products')->where('id',$id)->first();
        $check = DB::table('pos')->where('product_id',$id)->first();

        if($check){
            DB::table('pos')->where('product_id',$id)->increment('product_qty');

            $cartproduct = DB::table('pos')->where('product_id',$id)->first();

            $subtotal = $cartproduct->product_price*$cartproduct->product_qty;
            DB::table('pos')->where('product_id',$id)->update([
                'subtotal' => $subtotal
            ]);
        }else{
            $data = [];
            $data['product_id']     = $id;
            $data['product_name']   = $product->product_name;
            $data['product_qty']    = 1;
            $data['product_price']  = $product->selling_price;
            $data['subtotal']       = $product->selling_price;

            DB::table('pos')->insert($data);
        }
    }

    public function cartProducts(){
        $carts = DB::table('pos')->get();
        return response()->json($carts);
    }

    public function removeProduct($id){
        DB::table('pos')->where('id',$id)->delete();
    }

    public function cartInceament($id){
        $qty = DB::table('pos')->where('id',$id)->increment('product_qty');
        $product = DB::table('pos')->where('id',$id)->first();

        $subtotal = $product->product_price*$product->product_qty;
        DB::table('pos')->where('id',$id)->update([
            'subtotal' => $subtotal
        ]);
    }

    public function cartDecrement($id){
        $qty = DB::table('pos')->where('id',$id)->decrement('product_qty');
        $product = DB::table('pos')->where('id',$id)->first();

        $subtotal = $product->product_price*$product->product_qty;
        DB::table('pos')->where('id',$id)->update([
            'subtotal' => $subtotal
        ]);
    }

    public function getVat(){
        $vats = DB::table('extra')->first();
        return response()->json($vats);
    }
}

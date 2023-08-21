<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function get_product($id){
        $cat_products = DB::table('products')->where('category_id',$id)->get();
        return response()->json($cat_products);
    }

    public function orderDone(Request $request){
        $validateData = $request->validate([
            'customer_id' =>'required',
            'payBy' =>'required',
        ]);
    }
}

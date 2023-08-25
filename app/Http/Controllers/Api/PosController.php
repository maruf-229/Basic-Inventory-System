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

        $data = [];
        $data['customer_id']    = $request->customer_id;
        $data['qty']            = $request->qty;
        $data['sub_total']      = $request->subtotal;
        $data['vat']            = $request->vat;
        $data['total']          = $request->total;
        $data['pay']            = $request->pay;
        $data['due']            = $request->due;
        $data['payBy']          = $request->payBy;
        $data['order_date']     = date('d/m/y');
        $data['order_month']    = date('F');
        $data['order_year']     = date('Y');

        $order_id = DB::table('orders')->insertGetId($data);

        $contents = DB::table('pos')->get();

        $odata = [];

        foreach($contents as $content){
            $odata['order_id']          = $order_id;
            $odata['product_id']        = $content->product_id;
            $odata['product_qty']       = $content->product_qty;
            $odata['product_price']     = $content->product_price;
            $odata['subtotal']          = $content->subtotal;

            DB::table('order_details')->insert($odata);

            DB::table('products')->where('id',$content->product_id)->update([
                'product_quantity' => DB::raw('product_quantity -'.$content->product_qty)
            ]);
        }

        DB::table('pos')->delete();
    }

    public function todaysSell(){
        $date = date('d/m/y');

        $sell = DB::table('orders')->where('order_date',$date)->sum('total');
        return response()->json($sell);
    }

    public function todaysIncome(){
        $date = date('d/m/y');

        $income = DB::table('orders')->where('order_date',$date)->sum('pay');
        return response()->json($income);
    }

    public function todaysDue(){
        $date = date('d/m/y');

        $due = DB::table('orders')->where('order_date',$date)->sum('due');
        return response()->json($due);
    }

    public function todayExpense(){
        $date = date('d/m/y');

        $expense = DB::table('expenses')->where('expense_date',$date)->sum('amount');
        return response()->json($expense);
    }

    public function stockout(){
        $products = DB::table('products')->where('product_quantity','<',1)->get();
        return response()->json($products);
    }
}

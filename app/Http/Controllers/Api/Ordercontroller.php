<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ordercontroller extends Controller
{
    public function todayOrders(){
        $date = date('d/m/y');

        $orders = DB::table('orders')
                ->join('customers','orders.customer_id','customers.id')
                ->where('order_date',$date)
                ->select('customers.name','orders.*')
                ->orderBy('orders.id','DESC')->get();
        return response()->json($orders);
    }

    public function ordderDetails($id){
        $order = DB::table('orders')
                ->join('customers','orders.customer_id','customers.id')
                ->where('orders.id',$id)
                ->select('customers.name','customers.phone','customers.address','orders.*')
                ->first();
        return response()->json($order);
    }

    public function ordderDetailsAll($id){
        $order_details = DB::table('order_details')
                ->join('products','order_details.product_id','products.id')
                ->where('order_details.order_id',$id)
                ->select('products.product_name','products.product_code','products.image','order_details.*')
                ->get();
        return response()->json($order_details);
    }

    public function searchOrderDate(Request $request){
        $order_date = $request->date;
        $newDate = new DateTime($order_date);

        $date = $newDate->format('d/m/y');

        $order =  DB::table('orders')
                ->join('customers','orders.customer_id','customers.id')
                ->where('orders.order_date',$date)
                ->select('customers.name','orders.*')
                ->get();

        return response()->json($order);
    }
}

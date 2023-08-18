<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
                    ->join('categories','products.category_id','categories.id')
                    ->join('suppliers','products.supplier_id','suppliers.id')
                    ->select('categories.category_name','suppliers.name','products.*')
                    ->orderBy('products.id','DESC')
                    ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_name' =>'required|max:255',
            'product_code' =>'required|unique:products',
            'category_id' =>'required',
            'supplier_id' =>'required',
            'buying_price' =>'required',
            'selling_price' =>'required',
            'buying_date' =>'required',
            'product_quantity' =>'required',
        ]);

        $data = [];
        $data['category_id']           = $request->category_id;
        $data['product_name']          = $request->product_name;
        $data['product_code']          = $request->product_code;
        $data['root']                  = $request->root;
        $data['buying_price']          = $request->buying_price;
        $data['selling_price']         = $request->selling_price;
        $data['supplier_id']           = $request->supplier_id;
        $data['buying_date']           = $request->buying_date;
        $data['product_quantity']      = $request->product_quantity;

        $image = $request->image;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $data['image'] = $image_url;
                DB::table('products')->insert($data);
            }
        }

        else{
            DB::table('products')->insert($data);
        }
    }

    public function show($id)
    {
        $product = DB::table('products')->where('id',$id)->first();
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {


        $data = [];
        $data['category_id']           = $request->category_id;
        $data['product_name']          = $request->product_name;
        $data['product_code']          = $request->product_code;
        $data['root']                  = $request->root;
        $data['buying_price']          = $request->buying_price;
        $data['selling_price']         = $request->selling_price;
        $data['supplier_id']           = $request->supplier_id;
        $data['buying_date']           = $request->buying_date;
        $data['product_quantity']      = $request->product_quantity;

        $image = $request->newimage;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $data['image'] = $image_url;

                $img = DB::table('products')->where('id',$id)->first();
                $image_path = $img->image;
                unlink($image_path);

                DB::table('products')->where('id',$id)->update($data);
            }
        }

        else{
            $old_photo = $request->image;
            $data['image'] = $old_photo;

            DB::table('products')->where('id',$id)->update($data);
        }
    }

    public function destroy($id)
    {
        $product = DB::table('products')->where('id',$id)->first();
        $image = $product->image;

        if($image){
            unlink($image);
            DB::table('products')->where('id',$id)->delete();
        }else{
            DB::table('products')->where('id',$id)->delete();
        }
    }

    public function updateStock(Request $request, $id){
        $data = [];
        $data['product_quantity']      = $request->product_quantity;
        DB::table('products')->where('id',$id)->update($data);
    }
}

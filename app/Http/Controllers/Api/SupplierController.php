<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' =>'required|max:255',
            'email' =>'required|unique:suppliers|max:255',
            'phone' =>'required|unique:suppliers|max:255',
        ]);

        $data = [];
        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['phone']          = $request->phone;
        $data['address']        = $request->address;
        $data['shop_name']      = $request->shop_name;

        $image = $request->photo;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $data['photo'] = $image_url;
                $user = DB::table('suppliers')->insert($data);
            }
        }

        else{
            $user = DB::table('suppliers')->insert($data);
        }
    }

    public function show($id)
    {
        $supplier = DB::table('suppliers')->where('id',$id)->first();
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $data = [];
        $data = [];
        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['phone']          = $request->phone;
        $data['address']        = $request->address;
        $data['shop_name']      = $request->shop_name;

        $image = $request->newphoto;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $data['photo'] = $image_url;

                $img = DB::table('suppliers')->where('id',$id)->first();
                $image_path = $img->photo;
                unlink($image_path);

                $user = DB::table('suppliers')->where('id',$id)->update($data);
            }
        }

        else{
                $old_photo = $request->photo;
                $data['photo'] = $old_photo;

                $user = DB::table('suppliers')->where('id',$id)->update($data);
        }
    }

    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id',$id)->first();
        $photo = $supplier->photo;

        if($photo){
            unlink($photo);
            DB::table('suppliers')->where('id',$id)->delete();
        }else{
            DB::table('suppliers')->where('id',$id)->delete();
        }
    }
}

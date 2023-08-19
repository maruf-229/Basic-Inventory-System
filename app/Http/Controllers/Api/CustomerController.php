<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')->orderBy('id','DESC')->get();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' =>'required|max:255',
            'email' =>'nullable|unique:customers|max:255',
            'phone' =>'required|unique:customers|max:255',
            'address' =>'required',
        ]);

        $data = [];
        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['phone']          = $request->phone;
        $data['address']        = $request->address;

        $image = $request->photo;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/customer/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $data['photo'] = $image_url;
                $user = DB::table('customers')->insert($data);
            }
        }

        else{
            $user = DB::table('customers')->insert($data);
        }
    }

    public function show($id)
    {
        $customer = DB::table('customers')->where('id',$id)->first();
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        $data = [];
        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['phone']          = $request->phone;
        $data['address']        = $request->address;
        $image = $request->newphoto;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/customer/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if($success){
                $data['photo'] = $image_url;

                $img = DB::table('customers')->where('id',$id)->first();
                $image_path = $img->photo;
                unlink($image_path);

                $user = DB::table('customers')->where('id',$id)->update($data);
            }
        }

        else{
                $old_photo = $request->photo;
                $data['photo'] = $old_photo;

                $user = DB::table('customers')->where('id',$id)->update($data);
        }
    }

    public function destroy($id)
    {
        $customer = DB::table('customers')->where('id',$id)->first();
        $photo = $customer->photo;

        if($photo){
            unlink($photo);
            DB::table('customers')->where('id',$id)->delete();
        }else{
            DB::table('customers')->where('id',$id)->delete();
        }
    }
}

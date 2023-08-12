<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_name' =>'required|unique:categories|max:255',
        ]);

        $data = [];
        $data['category_name']  = $request->category_name;

        DB::table('categories')->insert($data);
    }

    public function show($id)
    {
        $category = DB::table('categories')->where('id',$id)->first();
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'category_name' =>'required|unique:categories|max:255',
        ]);

        $data = [];
        $data['category_name']  = $request->category_name;

        DB::table('categories')->where('id',$id)->update($data);
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id',$id)->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
    }


    public function store(Request $request)
    {
        $rules = [

            'name' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 400);
        }


        $category = new Category();
        $category->name = request('name');
        $category->save();

        return response()->json(['success' => 'Category added successfully'], 200);
    }


    public function Update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = request('name');
        $category->save();

        return response()->json(['success' => 'Category updated successfully'], 200);
    }
    public function show( $id)
    {
        $category = Category::find($id);
        

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category =  Category::find($id);
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully'], 200);
    }
}

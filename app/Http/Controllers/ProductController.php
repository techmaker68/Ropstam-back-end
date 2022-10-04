<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{


    public function index()
    {

        $products = Product::with('brand', 'category')->get();

        return response()->json($products, 200);
    }



    // add products 
    public function store(Request $request)
    {
        $rules = [

            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 400);
        }


        $filename = request('image')->getClientOriginalName();
        request()->image->move('productimage/', time() . $filename);
        $filename = url('productimage/' . time() . $filename);

        $Product = new Product();
        $Product->name = request('name');
        $Product->category_id = request('category_id');
        $Product->brand_id = request('brand_id');
        $Product->price = request('price');

        $Product->image = $filename;
        $Product->save();

        return response()->json(['success' => 'Product added successfully'], 200);
    }


    public function Update(Request $request, $id)
    {
        $filename='';

        $Product = Product::find($id);
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            request()->image->move('productimage/', time() . $filename);
            $filename = url('productimage/' . time() . $filename);
        }
        $Product->name = $request->name;
        $Product->category_id = $request->category_id;
        $Product->brand_id = $request->brand_id;
        $Product->price = $request->price;
        $Product->image = $filename;
        $Product->save();
        return response()->json(['success' => 'Product updated successfully'], 200);
    }


    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product, 200);
    }
    public function destroy($id)
    {
        $Product =  Product::find($id);
        $Product->delete();
        return response()->json(['success' => 'Product deleted successfully'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //
    public function index()
    {
        $brand = Brand::all();

        return response()->json($brand, 200);
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


        $Brand = new Brand();
        $Brand->name = request('name');
        $Brand->save();

        return response()->json(['success' => 'Brand added successfully'], 200);
    }
    public function show( $id)
    {
        $brand = Brand::find($id);
        return response()->json($brand, 200);
    }

    public function Update(Request $request, $id)
    {



        $Brand = Brand::find($id);
        $Brand->name = request('name');
        $Brand->save();

        return response()->json(['success' => 'Brand updated successfully'], 200);
    }

    public function destroy($id)
    {
        $Brand =  Brand::find($id);
        $Brand->delete();
        return response()->json(['success' => 'Brand deleted successfully'], 200);
    }
}

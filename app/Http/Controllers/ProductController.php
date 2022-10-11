<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'success'=>true,
            "message" => "Product list",
            "products" => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input,
        [
            "name" =>"required",
            "price" => "required",
            "user_id" =>'required',
            "categorie_id" => 'required'

        ]);

        if($validator->fails())
        {
            return $validator->errors();
        }
        else{

            $product = Product::create($input);

            return response()->json([
                "success" => true,
                'message' => "Created successfully"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return 'Error : product not found' ;
        }
        else{

            return response()->json([

                'success' => true,
                "product" =>$product
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input,
        [
            "name" =>"required",
            "price" => "required",
            "user_id" =>'required',
            "categorie_id" => 'required'

        ]);

        if($validator->fails())
        {
            return $validator->errors();
        }
        else {
           $product = Product::find($id);
            $product->update($request->all());
            
            return response([
                'message'=>'update successfully',
                'product'=> $product
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([

            "success" => true,
            "message" => "Deleted successfully"
        ]);
    }
}

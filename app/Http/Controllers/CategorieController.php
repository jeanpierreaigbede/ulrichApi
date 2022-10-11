<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::all();
        return response()->json([
            "sucess" => true,
            "message" => "Categorie List",
            "categories" => $categories
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
            ["name_type" => 'required',
            "user_id" => 'required',]
    );
    if($validator->fails()){

        return $validator->errors();
    }
    else{

        $categorie = Categorie::create($input);

        return response()->json([
            'sucess' => true,
            'message' => " Categorie created sucessfully"
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
        $categorie = Categorie::find($id);
        
        if(is_null($categorie)){

            return $this->sendError('Categorie not found !');
        }
        else{
            return response()->json(
                [
                    "success" => true,
                    "message" => 'Categorie found',
                    "data" => $categorie
                ]
                );
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
            "name_type" => 'required',
            "user_id" => 'required',
        ]);

        if($validator->fails())
        {
            return $validator->errors();
        }
        else {
            $categorie = Categorie::find($id);
            $categorie->update($request->all());
            
            return $categorie ;
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
        $categorie = Categorie::find($id);
        $categorie->delete();
        return response()->json([
            "success" => true,
            "message" => "Categorie deleted suceesfully"
        ]);
    }
}

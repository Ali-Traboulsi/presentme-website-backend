<?php

namespace App\Http\Controllers;

use App\Gender;
use Exception;
use Illuminate\Http\Request;

class GenderController extends Controller
{
     public function create(Request $request){

        try{

            //

        return response()->json([
            'error' => false,
            'message' => "The GenderController has been added successfully"
        ],201);

    }catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errormessage' => $errorInfo
            ],500);
        }
    }

   public function retrieve(Request $request){
      try{
          $genders = Gender::paginate();
          return response()->json([
              'error'=>false,
              'data'=>$genders
          ],200);
      }
      catch(\Illuminate\Database\QueryException $exception){
        $errorInfo = $exception->errorInfo;
        return response()->json([
            'error' => true,
            'message' => "Internal error occured"
        ],500);
      }

    }

    public function getGender($id){
        try{
            $gender = Gender::where('id', '=', $id)->first();
            return response()->json([
                'error'=>false,
                'data'=>$gender
            ],200);
        }
        catch(\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured"
            ],500);
        }

    }

    public function update(Request $request,$id){
       try{
           $gender = Gender::where('id', '=', $id)->first();
           //$X->name = $request['name'];
           $gender->update();
           return response()->json([
            'error'=>false,
            'message'=>'The GenderController has been updated successfully',
            'X'=>$gender
           ],200);
       }
      catch(\Illuminate\Database\QueryException $exception){
        $errorInfo = $exception->errorInfo;
        return response()->json([
            'error' => true,
            'message' => "Internal error occured"
        ],500);
       }
    }

}



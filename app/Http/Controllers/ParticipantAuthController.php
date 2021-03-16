<?php

namespace App\Http\Controllers;

use App\Participant;
use Exception;
use Illuminate\Http\Request;

class ParticipantAuthController extends Controller
{
     public function create(Request $request){

        try{
        //
        ParticipantAuthController::create(array(
            //
        ));

        return response()->json([
            'error' => false,
            'message' => "The ParticipantAuthController has been added successfully"
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
          $X = ParticipantAuthController::paginate();
          return response()->json([
              'error'=>false,
              'X'=>$X
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
           $X = ParticipantAuthController::where('id', '=', $id)->first();
           //$X->name = $request['name'];
           $X->save();
           return response()->json([
            'error'=>false,
            'message'=>'The ParticipantAuthController has been updated successfully',
            'X'=>$X
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



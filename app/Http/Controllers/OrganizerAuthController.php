<?php

namespace App\Http\Controllers;

use App\Organizer;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizerStoreRequest;

class OrganizerAuthController extends Controller
{
     public function register(OrganizerStoreRequest $request){

        try{

        $organizer = Organizer::create(array(
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'first-name' => $request->get('first-name'),
            'last-name' => $request->get('last-name'),
            'why-to-join' => $request->get('why-to-join'),
            'date-of-birth' => $request->get('date-of-birth'),
            'previous-experience' => $request->get('previous-experience'),
            'gender' => $request->get('gender'),
            'password' => bcrypt($request->get('password')),
            'avatar' => $request->get('avatar'),
            'level_id' => 1
        ));


        $token = auth()->guard('organizers')->login($organizer);

        return $this->respondWithToken($token);

        }catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errormessage' => $errorInfo
            ],500);
        }
    }

    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (! $token = auth()->guard('organizers')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        }
        catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errormessage' => $errorInfo
            ],500);
        }

    }

    public function logout()
    {
        try {

            auth()->guard('organizers')->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }
        catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errormessage' => $errorInfo
            ],500);
        }

    }

    public function retrieve(OrganizerStoreRequest $request){
      try{
          $organizer = Organizer::paginate();
          return response()->json([
              'error'=>false,
              'organizer'=>$organizer
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

    public function update(OrganizerStoreRequest $request, $id){
       try{
           $organizer = Organizer::where('id', '=', $id)->first();
           $organizer->name = $request['name'];
           $organizer->update();
           return response()->json([
            'error'=>false,
            'message'=>'The organizer account has been updated successfully',
            'data'=>$organizer
           ],200);
       }
      catch(\Illuminate\Database\QueryException $exception){
        $errorInfo = $exception->errorInfo;
        return response()->json([
            'error' => true,
            'message' => "Internal error occured",
            'errorInfo' => $errorInfo
        ],500);
       }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }

}



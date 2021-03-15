<?php

namespace App\Http\Controllers;

use App\Admin;
use Exception;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
     public function register(Request $request){

        try{

            $admin = Admin::create(array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ));

            $token = auth()->guard('admins')->login($admin);

            return $this->respondWithToken($token);

//            return response()->json([
//            'error' => false,
//            'message' => "The admin has been registered successfully",
//            'data' => $admin
//        ],201);

        }catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errorInfo' => $errorInfo
            ],500);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('admins')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->guard('admins')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function destroy($id) {

        try {
            $admin = Admin::where('id', '=', $id)->first();
            $admin->delete();

            return response()->json([
                'error'=>false,
                'message'=>'The admin has been deleted successfully',
                'admin'=>$admin
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
            'expires_in'   => auth()->guard('admins')->factory()->getTTL() * 60
        ]);
    }

}



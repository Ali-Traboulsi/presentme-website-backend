<?php

namespace App\Http\Controllers;

use App\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminAuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {

        try{

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->toJson()
                ], 400);
            }

//            $data = [
//                'username' => $request->get('username'),
//                'email' => $request['email'],
//                'first-name' => $request->get('first-name'),
//                'last-name' => $request->get('last-name'),
//                'date-of-birth' => $request->get('date-of-birth'),
//                'password' => bcrypt($request->get('password')),
//                'avatar' => $request->get('avatar'),
//            ];

            $data = $request->all();
            $admin = new Admin();
            $admin->fill($data);
            $admin->save();

            return response()->json([
                'success' => true,
                'data' => $admin
            ], 200);

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


    public function login (Request $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->only('email', 'password');

        try {
            if (! $token = auth('admins')->attempt($input)){
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid Credentials: email or password'
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Could not create token'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sign in Success',
            'token' => $token
        ]);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->validate($request, [
                'token' => 'required'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => 'false',
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
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

}



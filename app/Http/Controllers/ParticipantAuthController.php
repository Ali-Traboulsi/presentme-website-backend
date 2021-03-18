<?php

namespace App\Http\Controllers;

use App\Participant;use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

class ParticipantAuthController extends Controller
{

     public function register(Request $request): \Illuminate\Http\JsonResponse
     {

        try{

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'first-name' => 'required|string|max:255',
                'last-name' => 'required|string|max:255',
                'password' => 'required|string|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->toJson()
                ], 400);
            }

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filepath = $request->get('first-name').'-'.$request->get('last-name').'.'.$avatar->getClientOriginalExtension();
                $avatar->storeAs('public/avatars/participants', $filepath);
            }


            $data = [
                'username' => $request->get('username'),
                'email' => $request['email'],
                'first-name' => $request->get('first-name'),
                'last-name' => $request->get('last-name'),
                'date-of-birth' => $request->get('date-of-birth'),
                'password' => bcrypt($request->get('password')),
                'avatar' => $filepath,
            ];

            $participant = new Participant();
            $participant->fill($data);
            $participant->save();

            return response()->json([
                'success' => true,
                'data' => $participant
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
            if (! $token = auth('participants')->attempt($input)){
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
                'message' => 'Admin has been logged out'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => 'false',
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function retrieve(Request $request){
        try{
            $participant = Participant::paginate();
            return response()->json([
                'error' => false,
                'participant' => $participant
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
           $participant = Participant::where('id', '=', $id)->first();
//           $participant->name = $request['name'];
           $participant->update($request->all());
           return response()->json([
            'error'=>false,
            'message'=>'The ParticipantAuthController has been updated successfully',
            'data'=>$participant
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



<?php

namespace App\Http\Controllers;

use App\Organizer;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizerStoreRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
class OrganizerAuthController extends Controller
{
     public function register(Request $request): \Illuminate\Http\JsonResponse
     {

        try{

            // check for image uplaod
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filepath = $request->get('first-name').'-'.$request->get('last-name').'.'.$avatar->getClientOriginalExtension();
                $avatar->storeAs('public/avatars/organizers', $filepath);
            }

            $data = [
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'first-name' => $request->get('first-name'),
                'last-name' => $request->get('last-name'),
                'why-to-join' => $request->get('why-to-join'),
                'date-of-birth' => $request->get('date-of-birth'),
                'previous-experience' => $request->get('previous-experience'),
                'gender_id' => $request->get('gender_id'),
                'password' => $request->get('password'),
                'avatar' => $filepath,
                'level_id' => '1'
            ];

            $organizer = new Organizer();
            $organizer->fill($data);

            $organizer->save();

            return response()->json([
                'success' => true,
                'data' => $organizer
            ], 200);


        }catch (\Illuminate\Database\QueryException $exception) {
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
            if (! $token = auth('organizers')->attempt($input)){
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


}



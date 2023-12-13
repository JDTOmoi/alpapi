<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUser(){
        $users = User::all();
        return UserResource::collection($users);
    }

    public function createUser(Request $request){
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->driver = '0';
            $user->save();
            return [
                'status' => Response::HTTP_OK,
                'message' => "Success",
                'data' => $user
            ];
        }catch(Exception $e){
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'date' => []
            ];
        }
    }

    public function updateUser(Request $request){
        if(!empty($request->email)){
            $user = User::where('user_id', $request->id)->first();
        }else{
            $user = User::where('email', $request->email)->first();
        }

        if(!empty($user)){
            try{
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->phone = $request->phone;
                $user->save();
                return [
                    'status' => Response::HTTP_OK,
                    'message' => "Success",
                    'data' => $user
                ];
            }catch(Exception $e){
                return [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => $e->getMessage(),
                    'date' => []
                ];
            }
        }

        return [
            'status' => Response::HTTP_NOT_FOUND,
            'message' => "User not found",
            'data' => []
        ];
    }
    public function deleteUser(Request $request) {
        $user = User::where('user_id', $request->id)->first();
        $user->delete();

        return [
            'status' =>Response::HTTP_OK,
            'message' => 'Success',
            'data' => $user
        ];
    }
}
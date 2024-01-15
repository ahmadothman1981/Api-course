<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> ['required','string','max:255'],
            'email'=> ['required','email','max:255','unique:' . User::class],
            'password'=> ['required','confirmed',Rules\Password::defaults()]
        ],[],
        [
            'Name' => 'Name',
            'email'=>'Email',
            'password'=>'Password'
        ]);

        if($validator->fails())
        {
            return ApiResponse::sendResponse(422,'Validation Registration Error',$validator->messages()->all());
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $data['token'] = $user->createToken('course')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(201,' Accoount Registration Sucessfully',$data);


            }


             public function login(Request $request)
             {
                $validator = Validator::make($request->all(),[
                    'email'=> ['required','email','max:255'],
                    'password'=> ['required']
                ],[],
                [
                    'email'=>'Email',
                    'password'=>'Password'
                ]);

                if($validator->fails())
                {
                    return ApiResponse::sendResponse(422,'Validation Login Error',$validator->messages()->all());
                }

               if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,]))
               {
                $user = Auth::user();
               
                 $data['token'] = $user->createToken('course')->plainTextToken;
                 $data['name'] = $user->name;
                 $data['email'] = $user->email;
                 return ApiResponse::sendResponse(200,'User Login Sucessfully',$data);

               }else{
                 return ApiResponse::sendResponse(401,'User Credintials Does\'t match',[]);

            }

        }

        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();

            return ApiResponse::sendResponse(200,'loged out successfully',[]);
        }
}

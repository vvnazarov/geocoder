<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            'login' => 'required|string',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if($validate->fails()){
            return ['error'=>'401','message'=>'fields have error'];
        }

        $user = User::where('email', $request->login)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return ['error'=>'403','message'=>'The user with this data does not exist'];
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return 'true';
    }


}

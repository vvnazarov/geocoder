<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Faker\Provider\en_US\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function index(Request $request){
        $apikeys_user = Auth::user()->apikeys;

        return \App\Http\Resources\ApiKey::collection($apikeys_user);


    }

    public function store(Request $request){

        $key =  new ApiKey();

        $key->key = Str::random(80);
        $key->user_id = Auth::user()->id;

        $key->save();

        return ['apikey'=>new \App\Http\Resources\ApiKey($key)];

    }

    public function destroy(Request $request,$id){
        $apikeys_user = Auth::user()->apikeys->where('id',$id)->first();
        if($apikeys_user){
            $apikeys_user->delete();
            return 'true';
        }
        return ['error'=>'408','message'=>'The Api Key doesn\'t exist or you don\'t have access to it'];
    }

    public function show(Request $request,$id){
        $apikeys_user = Auth::user()->apikeys->where('id',$id)->first();

        if($apikeys_user)
            return ['apikey'=>new \App\Http\Resources\ApiKey($apikeys_user)];

        return ['error'=>'408','message'=>'The Api Key doesn\'t exist or you don\'t have access to it'];
    }
}

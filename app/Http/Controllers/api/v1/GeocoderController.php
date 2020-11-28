<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\CacheGeocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yandex\Geocode\Facades\YandexGeocodeFacade;

class GeocoderController extends Controller
{
    public function search(Request $request){
        $validate = Validator::make($request->all(),[
            'apikey'=>'required',
            'city'=>'string|required',
            'street'=>'string',
            'building'=>'string',
            'flat'=>'string',
//            'postcode'=>'string',
        ]);
        if($validate->fails()){
            return ['error'=>'401','message'=>$validate->getMessageBag()];
        }

        if(!\App\Models\ApiKey::checkApiKey($request->input('apikey'))){
            return ['error'=>'408','message'=>'The Api Key doesn\'t exist or you don\'t have access to it'];
        }


        $address_field = ''.$request->input('city').' '.$request->input('street')
            .' '.$request->input('building').' '.$request->input('flat');


        $cash = CacheGeocode::checkCash($address_field);
        if($cash){
            return response()->json($cash);
        }

        $data = YandexGeocodeFacade::setQuery('  '.$address_field)->load();
        $data = $data->getResponse()->getData();

        CacheGeocode::setCash($address_field,$data);

        return response()->json($data,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }
}

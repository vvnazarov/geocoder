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
            'address'=>'string',
            'city'=>'string',
            'street'=>'string',
            'building'=>'string',
            'flat'=>'string',
        ]);
        if($validate->fails()){
            return ['error'=>'401','message'=>$validate->getMessageBag()];
        }
        if(!\App\Models\ApiKey::checkApiKey($request->input('apikey'))){
            return ['error'=>'408','message'=>'The Api Key doesn\'t exist or you don\'t have access to it'];
        }
        if($request->input('address')) {
            $address_field = $request->input('address');

        }else{
            $address_field = '' . $request->input('city') . ' ' . $request->input('street')
                . ' ' . $request->input('building') . ' ' . $request->input('flat');
        }

        $cash = CacheGeocode::checkCash($address_field);
        if($cash){
            $cash = ($cash);
        }else{
            $data = YandexGeocodeFacade::setQuery('  '.$address_field)->load();
            $cash = $data->getResponse()->getRawData();
            $cash = (array)($cash);
            CacheGeocode::setCash($address_field,$cash);
        }



//        return ($cash['metaDataProperty']['GeocoderMetaData']['precision']);

        $match = true;
        if($cash['metaDataProperty']['GeocoderMetaData']['precision'] !='exact')
            $match = false;
        $data = [];
        $data['match'] = $match;
        $data['result']['precision']=$cash['metaDataProperty']['GeocoderMetaData']['precision'];
        $data['result']['text']= $cash['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
        $data['result']['kind']= $cash['metaDataProperty']['GeocoderMetaData']['kind'];

        return response()->json($data,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }

    public function locality(Request $request){
        $validate = Validator::make($request->all(),[
            'apikey'=>'required',
            'city'=>'string|required',
            'lang'=>'string|min:2|max:2',


        ]);

        if($validate->fails()){
            return ['error'=>'401','message'=>$validate->getMessageBag()];
        }

        if(!\App\Models\ApiKey::checkApiKey($request->input('apikey'))){
            return ['error'=>'408','message'=>'The Api Key doesn\'t exist or you don\'t have access to it'];
        }

        $url = 'http://geohelper.info/api/v1/cities?apiKey='.env('GEOHELPER_API_KEY').'&filter[name]='.$request->input('city').'&locale[lang]='.$request->input('lang');

        $response = \Illuminate\Support\Facades\Http::withOptions([
//                        'debug' => true,
        ])->get($url);


        $returnA = [];

        $response = json_decode($response->body());
        $rez = $response->result;
        foreach ($rez as $item){
            $returnA[count($returnA)]['id'] = $item->id;
            $returnA[count($returnA)-1]['name'] ='';
            if(isset($item->localityType->name))
                $returnA[count($returnA)-1]['name'] = $item->localityType->name.' ';
            $returnA[count($returnA)-1]['name'] .= $item->name;
            if(isset($item->area ) ) {
                $returnA[count($returnA)-1]['name'] .= ', '.$item->area.' район' ;
            }



//            else{
                $url = 'http://geohelper.info/api/v1/regions?apiKey='.env('GEOHELPER_API_KEY').'&filter[id]='.$item->regionId.
                    '&locale[lang]='.$request->input('lang');

                $response = \Illuminate\Support\Facades\Http::withOptions([
//                        'debug' => true,
                ])->get($url);
                $response = json_decode($response->body());
                $response = $response->result[0];

//                $returnA[count($returnA)-1]['regionId'] =$response->name;
                $returnA[count($returnA)-1]['name'] .= ', '.$response->name;
            }

        return ["success"=> true, "language"=> $request->input('lang'),'result'=>$returnA];

    }

    public function street(Request $request){
        $validate = Validator::make($request->all(),[
            'apikey'=>'required',
            'city'=>'int|required',
            'street'=>'string|required',
            'lang'=>'string|min:2|max:2',


        ]);

        if($validate->fails()){
            return ['error'=>'401','message'=>$validate->getMessageBag()];
        }

        if(!\App\Models\ApiKey::checkApiKey($request->input('apikey'))){
            return ['error'=>'408','message'=>'The Api Key doesn\'t exist or you don\'t have access to it'];
        }

        $url = 'http://geohelper.info/api/v1/streets?apiKey='.env('GEOHELPER_API_KEY').'&filter[name]='.$request->input('street').
            '&locale[lang]='.$request->input('lang').'&filter[cityId]='.$request->input('city');

        $response = \Illuminate\Support\Facades\Http::withOptions([
//                        'debug' => true,
        ])->get($url);
        $returnA = [];

        $response = json_decode($response->body());
        $rez = $response->result;
        foreach ($rez as $item){
            $returnA[count($returnA)]['id'] = $item->id;
            $returnA[count($returnA)-1]['name'] = '';
            if(isset($item->localityType->name))
                $returnA[count($returnA)-1]['name'] .= $item->localityType->name.' ';
            $returnA[count($returnA)-1]['name'] .= $item->name;
            $returnA[count($returnA)-1]['cityId'] = $item->cityId;
//            $returnA[count($returnA)-1]['postCode'] = $item->postCode;
        }

        return ["success"=> true, "language"=> $request->input('lang'),'result'=>$returnA];

    }

}

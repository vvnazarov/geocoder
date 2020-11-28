<?php


namespace App\Services;


class CacheGeocode
{
    public static function checkCash($address){
        $cash = \App\Models\CacheGeocode::where('request',$address)->first();
        if($cash){
            return $cash->result;
        }
        else
            return null;
    }

    public static function setCash($address,$result){
        $cash  = new \App\Models\CacheGeocode();

        $cash->request = $address;
        $cash->result = $result;

        $cash->save();
    }
}

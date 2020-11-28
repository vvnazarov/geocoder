<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    use SoftDeletes;

    public function getApikeyAttribute()
    {
        return $this->id.'|'.$this->key;
    }

    public static function checkApiKey($apikey){
        $mas = explode('|', $apikey, 2);
        if(count($mas) != 2)
            return false;
        $idKey = $mas[0];
        $key = $mas[1];

        $keyM = ApiKey::find($idKey);
        if($keyM && $keyM->key == $key){
            return true;
        }
        return false;
    }

}

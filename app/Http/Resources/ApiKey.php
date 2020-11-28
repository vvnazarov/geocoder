<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiKey extends JsonResource
{

    use SoftDeletes;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'apikey' => $this->apikey,
            'created_at' => $this->created_at
        ];
    }
}

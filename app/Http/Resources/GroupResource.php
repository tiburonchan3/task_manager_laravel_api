<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this->resource->id,
            "name"=>$this->resource->name,
            "admin_id"=>$this->resource->admin_id,
            "banner" => $this->resource->banner,
            "admin"=>$this->resource->user->name
        ];
    }
}
//Janeth Rubio - Live P3

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    #this function returned a json array
    public function toArray($request)
    {
        #return a json array
        return [
          'task' => $this->resource->task,
          'state' => $this->resource->state
        ];
    }
}

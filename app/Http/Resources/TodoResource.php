<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'label' => (string)$this->label,
            'status'=> (string)$this->status,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,

            //Chamando as Tasks com seu próprio resource
            'tasks' => TodoTaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}

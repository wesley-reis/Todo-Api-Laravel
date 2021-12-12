<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\This;

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
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'totalTasks' => (integer) $this->tasks()->count(),
            'tasksComplete' => (integer)$this->tasks()->where("is_complete", true)->count(),

            //Chamando as Tasks com seu próprio resource
            'tasks' => TodoTaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}

<?php

namespace App\Http\Resources\Task;

use App\Task;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'tasks';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tasks' => $this->collection->transform(function(Task $task) {
                return (new TaskResource($task));
            }),
        ];
    }
}

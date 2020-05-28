<?php

namespace App\Http\Resources\Label;

use App\Label;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LabelCollection extends ResourceCollection
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'labels';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'labels' => $this->collection->transform(function(Label $label) {
                return (new LabelResource($label));
            }),
        ];
    }
}

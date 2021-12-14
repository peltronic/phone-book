<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PhonenumberCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return parent::toArray([
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ]);
    }
}

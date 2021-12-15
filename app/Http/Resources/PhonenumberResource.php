<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhonenumberResource extends JsonResource
{
    public function toArray($request)
    {
        $base = parent::toArray($request);
        return $base;
    }
}

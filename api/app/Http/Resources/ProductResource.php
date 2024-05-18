<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->formattedPrice(),
            'description' => $this->description,
            'photo' => $this->photo,
            'quantity' => $this->quantity,
        ];
    }
}

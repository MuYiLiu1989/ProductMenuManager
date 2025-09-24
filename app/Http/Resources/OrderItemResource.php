<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        $categories = ProductCategory::orderBy('sort')->pluck('name', 'id')->toArray();
        return [
        	'id' => $this['id'],
            'name'     => $this['name'],
            'category' => $categories[$this['category']],
            'quantity' => $this['quantity'],
            'price'    => $this['price'],
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductItemResource extends JsonResource
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
        	'id' => $this->id,
        	'name' => $this->name,
        	'category' => $categories[$this->category_id],
        	'stock' => $this->stock,
        	'price' => $this->price,
        	'sort' => $this->sort,
        	'updated_at' => $this->updated_at->toDateTimeString(),
        	'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
    /*
    public function with($request)
    {
        return [
            'meta' => [
                'status' => 'success',
                'requested_at' => now(),
            ]
        ];
    }
    無效
    */
}

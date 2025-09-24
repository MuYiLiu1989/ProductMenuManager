<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        $users = User::pluck('name', 'id')->toArray();
        return [
            'id' => $this->id,
            'user' => $users[$this->user_id],
            'price' => $this->price,
            'items' => OrderItemResource::collection($this->order),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
	protected $guarded = ['id']; // 除了 `id` 之外，其他欄位皆可批量填充

	protected $casts = [
        'price' => 'integer',
        'order' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

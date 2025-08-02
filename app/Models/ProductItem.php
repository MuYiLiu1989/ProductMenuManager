<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = ['is_visible','name','category_id','price','stock','sort'];

    protected $guarded = ['id'];
}

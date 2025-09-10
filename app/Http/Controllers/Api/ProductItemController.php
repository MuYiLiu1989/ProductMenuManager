<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductItem;
use App\Models\ProductCategory;
use App\Http\Resources\ProductItemResource;
use Illuminate\Http\Request;

class ProductItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('categoryId'); // 取出 GET 參數
        
        if ($categoryId) {
            $items = ProductItem::where('is_visible',1)->where('category_id', $categoryId)->orderBy('sort')->get();
        }else{
        	$items = [];
        }
        return ProductItemResource::collection($items)->additional([
    		'meta' => ['status' => 'success','requested_at' => now()]
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

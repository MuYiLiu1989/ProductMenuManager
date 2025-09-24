<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderList;
use App\Http\Resources\OrderListResource;
use Illuminate\Http\Request;

class OrderListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
      
        if ($user->is_product_manager) {
            $items = OrderList::orderBy('created_at','desc')->get();
        }else{
        	$items = OrderList::where('user_id', $user->id)->orderBy('created_at','desc')->get();
        }
        return OrderListResource::collection($items)->additional([
    		'meta' => ['status' => 'success','requested_at' => now()->toDateTimeString(),'count' => $items->count()]
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

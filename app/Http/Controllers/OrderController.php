<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductItem;
use App\Models\ProductCategory;
use App\Support\SessionReader;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function menu(Request $request){
    	
    	$categories = ProductCategory::orderBy('sort')->get(['id', 'name'])->toArray();

        $categoryId = $request->query('categoryId'); // 取出 GET 參數
        
        if ($categoryId) {
            $items = ProductItem::where('is_visible',1)->where('category_id', $categoryId)->orderBy('sort')->get();
        }else{
        	$items = [];
        }

        return Inertia::render('ProductOrder/Menu', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }
    public function cart(Request $request, SessionReader $sessionReader){

    	if (isset($request->id) && isset($request->quantity)){
    		
    		$request->session()->increment($request->id,(int) $request->quantity);

    	}

    	$cart = $sessionReader->all();

    	$categories = ProductCategory::pluck('name','id');

    	if ($cart==null){return Inertia::render('ProductOrder/Cart');}else{
    		$items = [];
    	foreach ($cart as $id => $quantity){
    		$itemDB = ProductItem::findOrFail($id);
    		$item['id'] = $id;
    		$item['name'] = $itemDB->name;
    		$item['category'] = $itemDB->category_id;
    		$item['price'] = $itemDB->price;
    		$item['quantity'] = $quantity;
    		$item['stock'] = $itemDB->stock;
    		$items[] = $item;
    	}

    	//dd(session()->all());

    	return Inertia::render('ProductOrder/Cart', [
            'items' => $items,
            'categories' => $categories
        ]);}
    }
    public function ajax(Request $request){

    	$action = $request->query('action'); // 取出 GET 參數

    	switch ($action){
    		case 'plus':
    			$request->session()->increment($request->input('id'));
    			return response()->json(['quantity' => $request->session()->get($request->input('id'))]);
    			break;
    		case 'minus':
    			$request->session()->decrement($request->input('id'));
    			if ($request->session()->get($request->input('id')) == 0){
    				$request->session()->forget($request->input('id'));
    			}
    			//dd(session()->all());
    			return response()->json(['quantity' => $request->session()->get($request->input('id'))]);
    			break;
    		case 'delete':
    			$request->session()->forget($request->input('id'));
    			return response()->json(['result' => 'success']);
    			break;
    		default:
    			return response()->json(['error' => '沒有action']);
    			break;
    	}
    }

    public function orderlist(){
    	
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductItem;
use App\Models\ProductCategory;
use App\Models\OrderList;
use App\Support\SessionReader;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function menu(Request $request){
    	
    	$categories = ProductCategory::orderBy('sort')->get(['id', 'name'])->toArray();

        $categoryId = $request->query('categoryId'); // 取出 GET 參數
        
        if ($categoryId) {
            $items = ProductItem::where('is_visible',1)->where('category_id', $categoryId)->orderBy('sort')->get(); //唯有is_visible=1才會顯示在menu中
        }else{
        	$items = [];
        }

        return Inertia::render('ProductOrder/Menu', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }
    public function cart(Request $request, SessionReader $sessionReader)
    {
    	if (isset($request->id) && isset($request->quantity)){
    		
    		$request->session()->increment($request->id,(int) $request->quantity);

    	}

    	$cart = $sessionReader->all();
    	//dd($cart);
    	//dd(session()->all());

    	$categories = ProductCategory::pluck('name','id');
    	//購物車為空 或 session第一個key不是數字like id
    	if ($cart==null || !is_numeric(array_key_first($cart))){return Inertia::render('ProductOrder/Cart',['categories' => $categories]);}else{
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

    	return Inertia::render('ProductOrder/Cart', [
            'items' => $items,
            'categories' => $categories
        ]);}
    }

    public function submitProcess(Request $request)
    {
    	try{
	    	$data = $request->all();
	    	$json = [];
	    	$price = 0;
	    	foreach ($data as $item) {
	    		$item['stock'] = $item['stock'] - $item['quantity'];
	    		if ($item['stock'] < 0){
	    			abort(400, "{$item['name']}的購買量超過庫存量");
	    		}
	    		ProductItem::where('id','=',$item['id'])->update(['stock' => $item['stock']]);
	    		unset($item['stock']);
	    		$json[] = $item;
	    		$price += $item['price']*$item['quantity'];
	    		session()->forget($item['id']);
	    	}
	    	OrderList::create([
	    		'user_id' => auth()->id(),
	    		'order' => $json,
	    		'price' => $price,
	    	]);
	    	
	    	return redirect()->route('productOrder.cart')->with(['success' => '訂單已成功送出！']);
	    	//session key不能為數字

    	}catch(\Exception $e){
    		
    		return redirect()->route('productOrder.cart')->withErrors(['error' => $e->getMessage(), 'status' => $e->getStatusCode()]); //不能用getCode()方法，會變0
    	}
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

    public function orderlist()
    {
    	$categories = ProductCategory::pluck('name','id');

    	if(auth()->user()->is_product_manager){
    		$OrderLists = OrderList::with('user')->orderBy('created_at','desc')->get();
    		$is_product_manager = true;
    		$username = null;
    	}else{
    		$OrderLists = OrderList::where('user_id',auth()->id())->orderBy('created_at','desc')->get();
    		$is_product_manager = false;
    		$username = auth()->user()->name;
    	}
    	return Inertia::render('ProductOrder/OrderLists',[
    		'orderLists' => $OrderLists,
    		'categories' => $categories,
    		'is_product_manager' => $is_product_manager,
    		'username' => $username,
    	]);
    }
}

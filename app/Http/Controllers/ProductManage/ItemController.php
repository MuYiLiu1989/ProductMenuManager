<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductItem;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = ProductCategory::orderBy('sort')->pluck('name','id')->toArray();

        $categoryId = $request->query('categoryId'); // 取出 GET 參數
        
        if ($categoryId) {
            $items = ProductItem::where('category_id', $categoryId)->orderBy('sort')->get();
        }else{
        	$items = [];
        }

        return Inertia::render('ProductManage/ItemIndex', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('sort')->get();
        
        return Inertia::render('ProductManage/ItemForm', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        	'is_visible' => 'required',
            'name' => 'required|string|unique:product_items,name',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
        	'is_visible' => $request->is_visible,
        	'name' => $request->name,
        	'category_id' => $request->category_id,
        	'price' => $request->price,
        	'stock' => $request->stock,
            'sort' => (ProductItem::where("category_id",$request->category_id)->max('sort') ?? 0) + 1,
        ];

        ProductItem::create($data);
    
        // 儲存成功，使用 session flash 來傳遞成功訊息
        return redirect()->route('productManage.item.create')
            ->with('success', '項目已成功建立！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = ProductItem::findOrFail($id);
        $categories = ProductCategory::orderBy('sort')->get();
        return Inertia::render('ProductManage/ItemForm', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = ProductItem::findOrFail($id);
        $validator = Validator::make($request->all(), [
        	'is_visible' => 'required',
            'name' => 'required|string|unique:product_items,name,' . $id, //為了不要檢查是否跟自己重複
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $item->update([
        	'is_visible' => $request->is_visible,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if ($item->sort==0){
            $item->update([
                'sort' => (ProductItem::where("category_id",$request->category_id)->max('sort') ?? 0) + 1,
            ]);
        }

        return redirect()->route('productManage.item.edit', $id)
            ->with('success', '項目已成功更新！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = ProductItem::findOrFail($id);
            $item->delete();
            return redirect()->route('productManage.item.index')
                ->with('success', '項目已成功刪除！');
        } catch (\Exception $e) {
            return redirect()->route('productManage.item.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function ajax(Request $request)
    {
    	$action = $request->query('action'); // 取出 GET 參數
    	switch ($action) {
    		case 'sort':
    			// 驗證請求資料是陣列格式
    			$orginRrequest = $request->all();
    			array_pop($orginRrequest);
        		$bigRequest['sortChangeNum'] = $orginRrequest;
		        $validator = Validator::make($bigRequest, [
		        	'sortChangeNum' => 'required|array|min:1',
		            'sortChangeNum.*.id' => 'required|exists:product_items,id',
		            'sortChangeNum.*.sort' => 'required|integer',
		        ],[
		        	'sortChangeNum.required' => "至少須挪動一次！"
		        ]);
		    
		        if ($validator->fails()) {
		            return response()->json([
		                'success' => false,
		                'errors' => $validator->errors()->all(),
		            ]);
		        }
		    
		        // 處理陣列資料
		        $rawdata = $validator->validated();
		        $data = $rawdata["sortChangeNum"];
		        
		        foreach ($data as $item) {
		            ProductItem::where('id', $item['id'])->update(['sort' => $item['sort']]);
		        }
		    
		        return response()->json([
		            'success' => true,
		            'message' => '項目順序已成功更新！',
		        ]);
    			break;
    		case 'switchVisible':   
    			$productItem = ProductItem::findOrFail($request->id);
    			$productItem->update([
    				'is_visible' => $productItem->is_visible == 1 ? 0 : 1,
    			]);
                //以後來的為主
                if ($productItem->is_visible == 1){
    			return response()->json([
    				'success' => true,
    				'message' => '該項目已啟用！',
    			]);
                }else{
                    return response()->json([
                    'success' => true,
                    'message' => '該項目已停用！',
                ]);
                }
                break;
    		case 'updateStock':
                $validator = Validator::make($request->all(), [
                    'stock' => 'required'
                ],[
                    'stock.required' => "數字不可空白！"
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->all(),
                    ]);
                }
    			$productItem = ProductItem::findOrFail($request->id);
    			$productItem->update([
    				'stock' => $productItem->stock + $request->stock,
    			]);
    			return response()->json([
    				'success' => true,
    				'message' => "庫存已成功更新為{$productItem->stock}！",
    			]);
                break;
    		default:
    			return response()->json([
                        'success' => false,
                        'errors' => "沒選擇適當的action！",
                    ]);
    			break;
    	}
        
    }
}

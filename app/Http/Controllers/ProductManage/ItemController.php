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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('sort')->get();
        
        // 調試：檢查資料
        // dd($categories); // 取消註解來查看資料
        
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
            'sort' => (ProductCategory::max('sort') ?? 0) + 1,
        ];

        ProductItem::create($data);
    
        // 儲存成功，使用 session flash 來傳遞成功訊息
        return redirect()->route('productManage.item.create')
            ->with('success', '種類已成功建立！');
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

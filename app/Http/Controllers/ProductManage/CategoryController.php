<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductCategory;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 暫時移除條件限制來測試
        $categories = ProductCategory::orderBy('sort')->get();
        
        // 調試：檢查資料
        // dd($categories); // 取消註解來查看資料
        
        return Inertia::render('ProductManage/CategoryIndex', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ProductManage/CategoryForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:product_categories,name',
        ]);

        $data = $validator->validate();
    	/*
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
        	'name' => $request->name,
            'sort' => (ProductCategory::max('sort') ?? 0) + 1,
        ];
		*/
        $data['sort'] = (ProductCategory::max('sort') ?? 0) + 1;

        ProductCategory::create($data);
    
        // 儲存成功，使用 session flash 來傳遞成功訊息
        return redirect()->route('productManage.category.create')
            ->with('success', '種類已成功建立！');
        // with()這才是 session()->flash('success', '種類已成功建立！')，把資料暫存在 session 裡，只保留一次請求。

        // 不能用response()->json()
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
        $category = ProductCategory::findOrFail($id);
        
        return Inertia::render('ProductManage/CategoryForm', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ProductCategory::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:product_categories,name,' . $id,
        ]);

        $data = $validator->validate();
    	/*
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update([
            'name' => $request->name,
        ]);
        */
        $category->update($data);
    
        return redirect()->route('productManage.category.edit', $id)
            ->with('success', '種類已成功更新！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->delete();
            
            return redirect()->route('productManage.category.index')
                ->with('success', '種類已成功刪除！');
        } catch (\Exception $e) {
            return redirect()->route('productManage.category.index')
                ->withErrors(['error' => $e->getMessage()]);
            // 刪除失敗，請稍後再試。
        }
    }

    public function ajax(Request $request)
    {
        // 驗證請求資料是陣列格式
        $validator = Validator::make($request->all(), [
            '*.id' => 'required|exists:product_categories,id',
            '*.sort' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
            ]);
        }
    
        // 處理陣列資料
        $data = $request->all();
        
        foreach ($data as $item) {
            ProductCategory::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    
        return response()->json([
            'success' => true,
            'message' => '種類順序已成功更新！',
        ]);
    }
}

<template>
    <Head title="productManageCategoryIndex" />
    <AuthenticatedLayout>
        <template #header>
            <OrderButton></OrderButton>
        </template>
        <div class="py-12">
            <div class="mx-auto w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- 頁面標題和控制按鈕 -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">商品列表</h2>
                            <div class="hidden lg:block">
                            	<h2 class="text-2xl font-bold text-gray-800">種類：{{categories.find(cat=>cat.id==selectedId)?.name}}</h2>
                            	<!--直接用key對value的形式順序會跑掉-->
                        	</div>
                            <div class="my-2 flex items-center gap-4">
							  <label class="text-2xl font-bold text-gray-800 whitespace-nowrap">類別：</label>
							  <select  
							    class="flex-1 px-2 py-1 text-white text-2xl border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
							    v-model="selectedId"
                                @change="onChange"
							  >
							    <option value="">請選擇類別</option>
							    <option v-for="category in categories" :key="category" :value="category.id">{{ category.name }}</option>
							  </select>    
							</div>
							<div class="flex space-x-3">
                                <button 
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600  text-white font-medium rounded-lg shadow-sm transition-colors duration-200 flex items-center space-x-2"
                                >
                                    
                                    <a :href="route('productOrder.api',{categoryId:selectedId})">api預覽</a>
                                </button>
                                <button 
                                    class="px-4 py-2 bg-green-500 hover:bg-green-600  text-white font-medium rounded-lg shadow-sm transition-colors duration-200 flex items-center space-x-2"
                                    @click="getToken"
                                >
                                    
                                    <span>取得token</span>
                                </button>
                            </div>
                        </div>    
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        
                                        <th class="w-16 px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300 hidden">
                                            ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            項目名
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            價格
                                        </th>
                                        
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            商品訂購
                                        </th>

                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            目前庫存
                                        </th>
                                  
                                    	<!--
                                        <th class="w-20 px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            修改數量
                                        </th>
                                        <th class="w-20 px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            刪除
                                        </th>
                                    	-->
                                    </tr>
                                </thead>
                                <tbody
                                      class="bg-white divide-y divide-gray-200"
								    >
									    
		                                    <tr v-for="item in localItems" :key="item.id" class="hover:bg-gray-50 transition-colors duration-200">
                                                
		                                        <td class="w-16 px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900 hidden">
		                                            {{ item.id }}
		                                        </td>
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.name }}
		                                        </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.price }}
		                                        </td>
		                                        
	                                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
	                                                    <label class="text-lg font-semibold text-gray-800 mb-2">訂購數量：</label>
	                                                    <input 
	                                                        type="number"
	                                                        min='0' step='1' 
	                                                        :ref="el => productOrder[localItems.indexOf(item)] = el"
	                                                        class="w-32 px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
	                                                        placeholder="請輸入數字" 
	                                                    />
	                                                    <button class="mx-2 bg-green-500 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200" @click="orderProducts(item.id,localItems.indexOf(item))">訂購</button>
			                                        </td>
			                                    <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.stock }}
		                                        </td>
		                                    	<!--
		                                        <td class="w-20 px-6 py-4 whitespace-nowrap text-lg text-gray-900 text-center">
                                                    <button @click="editItem(element.id)" :disabled="isDraggable" class="bg-blue-500 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200">
		                                            修改
                                                    </button>
		                                        </td>
		                                        <td class="w-20 px-6 py-4 whitespace-nowrap text-lg text-gray-900 text-center">
                                                    <button @click="deleteItem(element.id,element.name)" :disabled="isDraggable" class="bg-red-500 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200">
		                                            刪除
                                                    </button>
		                                        </td>
		                                    -->
		                                    </tr>
		                                
                                        
                                            <tr v-if="localItems.length === 0">
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-xl">
                                                    這個種類沒有商品
                                                </td>
                                            </tr>
                                        
		                        </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import OrderButton from '@/Pages/OrderButton.vue';
import Swal from 'sweetalert2';
import Draggable from 'vuedraggable';
import axios from 'axios';
import { ref, computed, watch } from 'vue';

// 定義 props
const props = defineProps({
    categories: {
        type: Array,
        default: []
    },
    //經後端變成鍵值對應
    items: {
        type: Array,
        default: []
    }
    //經後端篩選過的items array
});
// localItems是本地創建的響應式副本from props.items用於拖曳

const params = new URLSearchParams(window.location.search);
var categoryId = params.get('categoryId')??'';//請選擇類別的value是''

const selectedId = ref(categoryId);
const localItems = ref([...props.items]); //與draggable的變化同步(v-model)
//ref裡的內容之後更新路由(updated)都不會用到(select選單一換類別馬上show出該類別項目，靠監聽)，除非按取消回來這裡或第一次進來這(mounted)

//const newOrder = ref([]); //如果沒拖曳半次就送出會送出空串列

//重新進一次controller再跑一次(可能多帶個get參數)
const onChange = () => {
  router.get(route('productOrder.menu'), { categoryId: selectedId.value }, {
    preserveScroll: true, //是否滾動
    preserveState: true, //響應式變數是否留存
    replace: true, // 可選，避免新增歷史紀錄
  })
}
// 用get參數控制後端所傳的資料(只傳get參數標明的類別資料)	
// 監聽 props.items 變化並同步到本地副本localItems
watch(() => props.items, (newItems) => {
  localItems.value = [...newItems];
  console.log(localItems.value);
}, { deep: true });
//如果不用監聽改用computed的get and set，這樣會害localItems變成唯讀(因為拖曳順序會改變localItems裡array的順序)，不然就要撰寫set內容

// 是否可拖曳
//const isDraggable = ref(false);

// 每拖曳完成一次後儲存新順序，按結束按鈕後isDraggable=false，儲存最終順序送ajax到後端

const productOrder = ref([]) // 存放所有 input DOM
//增減庫存量
function orderProducts(itemId,index) {
    router.post(route('productOrder.cart',{id:itemId}), {
        quantity: productOrder.value[index]?.value});
}

async function getToken(){
	try{
		const response = await axios.post('/api/login');
		Swal.fire({
            title: '成功！',
            text: response.data.message,
            icon: 'success',
            confirmButtonText: '確定'
        });
	} catch (error){
		Swal.fire({
	        title: '失敗！',
	        text: error,
	        icon: 'error',
	        confirmButtonText: '確定'
	    });
	}
}

</script>

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
                        <!-- 頁面標題 -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 v-if="is_product_manager" class="text-2xl font-bold text-gray-800">接收訂單紀錄</h2>
                            <h2 v-else class="text-2xl font-bold text-gray-800">{{username}}送出訂單紀錄</h2>
                            <h2 class="text-2xl font-bold text-gray-800">共{{localOrders.length}}筆</h2>
                            <h2 class="text-2xl font-bold text-gray-800">共{{totalPrice}}元</h2>
                        </div>    
                        
                        <div v-for="orderlist in localOrders" class="overflow-x-auto">
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
                                            種類
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            單價
                                        </th>
                                        
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            訂購數量
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            價格小計
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                      class="bg-white divide-y divide-gray-200"
								    >
									    
		                                    <tr v-for="item in orderlist.order" :key="item.id" class="hover:bg-gray-50 transition-colors duration-200">
                                                
		                                        <td class="w-16 px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900 hidden">
		                                            {{ item.id }}
		                                        </td>
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.name }}
		                                        </td>
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ categories[item.category] }}
		                                        </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.price }}
		                                        </td>
		                                        
	                                            <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
	                                              <p>{{ item.quantity }}</p>          
			                                    </td>
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
                                                    {{ item.price*item.quantity }}
		                                        </td>
		                                    </tr>
		                                	
		                                	<tr>
                                                <td colspan="5" class="px-6 py-8 text-black text-2xl">
                                                	<div class="flex justify-between">
                                                    	<span>總計：{{ orderlist.price }}</span>
                                      
                                                		<span v-if="is_product_manager">建立者：{{orderlist.user.name}}</span>
                                                
                                                		<span>{{new Date(orderlist.created_at).toLocaleString()}}</span>
                                                	</div>
                                                </td>
                                            </tr>
                                        
                                            
                                        
		                        </tbody>
                            </table>
                            <br>
                        </div>
                        <h2 class="py-4 text-black text-2xl" v-if="localOrders.length === 0">
                            查詢結果：沒有任何訂單
                        </h2>
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
    orderLists: {
        type: Array,
        default: []
    },
    //經後端篩選過的items array
    categories: {
    	type: Object,
    	default: null
    },
    is_product_manager: {
    	type: Boolean,
    	default: false
    },
    username: {
    	type: String,
    	default: null
    }
});
// localItems是本地創建的響應式副本from props.items用於拖曳

//const selectedId = ref(categoryId);
const localOrders = ref([...props.orderLists]); //與draggable的變化同步(v-model)，不過這裡的locatItems是唯讀
//ref裡的內容之後加加減減(updated)都不會用到，要自己更新頁面內容，除非離開後回來這裡或第一次進來這(mounted)

const totalPrice = computed(() => {
  return localOrders.value.reduce((sum, item) => sum + item.price, 0);
})

//重新進一次controller再跑一次(可能多帶個get參數)
const onChange = () => {
  router.get(route('productOrder.cart'), {
    preserveScroll: true, //是否滾動
    preserveState: true, //響應式變數是否留存
    replace: true, // 可選，避免新增歷史紀錄
  })
}

async function deleteItem(item){
	try{
		const response = await axios.post(route('productOrder.ajax'), {id: item.id},{params:{action:'delete'}});
		if (response.data.result == 'success'){
			localItems.value = localItems.value.filter(term => term.id !== item.id);
		}
	}catch(error){
		Swal.fire({
	        title: '失敗！',
	        text: error,
	        icon: 'error',
            confirmButtonText: '確定'
        });
	}
}

</script>

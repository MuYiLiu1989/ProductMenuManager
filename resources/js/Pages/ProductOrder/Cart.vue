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
                            <h2 class="text-2xl font-bold text-gray-800">購物車商品列表</h2>

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
                                            種類
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            單價
                                        </th>
                                        
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            訂購數量
                                        </th>

                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            目前庫存
                                        </th>
                                  	
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            價格小計
                                        </th>
                                    
                                        <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            刪除
                                        </th>
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
		                                            {{ categories[item.category] }}
		                                        </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.price }}
		                                        </td>
		                                        
	                                            <td class="flex justify-start gap-3 items-center px-6 py-4 whitespace-nowrap text-lg text-gray-900">
	                                            	<!-- 減號 -->
												  <button 
												    class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 active:scale-95 transition"
												    @click="crement(item,false)">
												    -
												  </button>
	                                              <p>{{ item.quantity }}</p> 
	                                            	<!-- 加號 -->
												  <button 
												    class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 active:scale-95 transition"
												    @click="crement(item,true)">
												    +
												  </button>       
			                                    </td>
			                                    <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ item.stock }}
		                                        </td>
		                                    	
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
                                                    {{ item.price*item.quantity }}
		                                        </td>
		                                   
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900 text-center">
                                                    <button @click="deleteItem(item)" class="bg-red-500 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200">
		                                            刪除
                                                    </button>
		                                        </td>
		                                    </tr>
		                                	
		                                	<tr v-if="localItems.length !== 0">
                                                <td colspan="4" class="px-6 py-8 text-black text-2xl">
                                                    總計：{{ totalPrice }}
                                                </td>
                                            </tr>
                                        
                                            <tr v-if="localItems.length === 0">
                                                <td colspan="7" class="px-6 py-8 text-gray-500 text-center text-xl">
                                                    購物車內沒有商品
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
    items: {
        type: Array,
        default: []
    },
    //經後端篩選過的items array
    categories: {
    	type: Object,
    	default: null
    }
});
// localItems是本地創建的響應式副本from props.items用於拖曳

//const selectedId = ref(categoryId);
const localItems = ref([...props.items]); //與draggable的變化同步(v-model)，不過這裡的locatItems是唯讀
//ref裡的內容之後加加減減(updated)都不會用到，要自己更新頁面內容，除非離開後回來這裡或第一次進來這(mounted)

const totalPrice = computed(() => {
  return localItems.value.reduce((sum, item) => sum + item.price*item.quantity, 0);
})

async function crement(item,plus) {
	try{
		
	const response = await axios.post(route('productOrder.ajax'), {id: item.id},{params:{action:plus?'plus':'minus'}});
	item.quantity = response.data.quantity;
	console.log(item.quantity);
	console.log(localItems.value);
	if (item.quantity == null){
		console.log("刪除該item");
		localItems.value = localItems.value.filter(term => term.id !== item.id);
		console.log(localItems.value);
		console.log(localItems.value.length);
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

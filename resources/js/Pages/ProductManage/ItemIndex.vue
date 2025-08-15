<template>
    <Head title="productManageCategoryIndex" />
    <AuthenticatedLayout>
        <template #header>
            <ManageButton></ManageButton>
        </template>
        <div class="py-12">
            <div class="mx-auto w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- 頁面標題和控制按鈕 -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">項目管理</h2>
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
                                    @click="isDraggable = true" 
                                    :disabled="isDraggable"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium rounded-lg shadow-sm transition-colors duration-200 flex items-center space-x-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                    <span>啟用拖曳</span>
                                </button>
                                <button 
                                    @click="savesort" 
                                    :disabled="!isDraggable"
                                    class="px-4 py-2 bg-green-500 hover:bg-green-600 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium rounded-lg shadow-sm transition-colors duration-200 flex items-center space-x-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>儲存順序</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- 拖曳狀態提示 -->
                        <div v-if="isDraggable" class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-yellow-800 font-medium">拖曳模式已啟用</span>
                                <span class="text-yellow-700 ml-2">- 您可以拖曳列表項目來重新排序，完成後請點擊「儲存順序」</span>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="w-16 px-6 py-4 text-left text-lg font-bold text-gray-700 whitespace-nowrap uppercase tracking-wider border-b border-gray-300">
                                            啟用
                                        </th>
                                        <th class="w-16 px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            項目名
                                        </th>
                                        <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            價格
                                        </th>
                                        <div class="hidden lg:block">
                                        	<th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            庫存管理
                                        	</th>
                                    	</div>
                                        <th class="w-20 px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            修改
                                        </th>
                                        <th class="w-20 px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            刪除
                                        </th>
                                    </tr>
                                </thead>
                                <Draggable
                                      v-model="localItems"
                                      item-key="id"
                                      :disabled="!isDraggable"
                                      tag="tbody"
                                      class="bg-white divide-y divide-gray-200"
                                      @end="saveNewOrder"
								    >
									    <template #item="{ element, index }">
		                                    <tr class="hover:bg-gray-50 transition-colors duration-200" :style="{ cursor: isDraggable ? 'move' : 'default' }">
                                                <td class="w-16 px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">
		                                            <!-- 勾號 -->
		                                        <button v-if="element.is_visible" @click="switchVisible(element.id)" :disabled="isDraggable" class="disabled:opacity-50 disabled:cursor-not-allowed
		                                        px-2">
													<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="green" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
													  <polyline points="20 6 9 17 4 12" />
													</svg>
												</button>
													<!-- 叉號 -->
												<button v-if="!element.is_visible" @click="switchVisible(element.id)" :disabled="isDraggable" class="disabled:opacity-50 disabled:cursor-not-allowed
												px-2">
													<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
													  <line x1="18" y1="6" x2="6" y2="18" />
													  <line x1="6" y1="6" x2="18" y2="18" />
													</svg>
												</button>
		                                        </td>
		                                        <td class="w-16 px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">
		                                            {{ element.id }}
		                                        </td>
		                                        <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ element.name }}
		                                        </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
		                                            {{ element.price }}
		                                        </td>
		                                        <div class="hidden lg:block">
	                                                <td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">
	                                                    <label class="text-lg font-semibold text-gray-800 mb-2">庫存增減：</label>
	                                                    <input 
	                                                        type="number" 
	                                                        :ref="el => stockInputs[index] = el"
	                                                        class="w-32 px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
	                                                        placeholder="請輸入數字" 
	                                                    />
	                                                    <button class="mx-2 bg-green-500 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200" @click="updateStock(element.id,index)" :disabled="isDraggable">更新</button>
			                                            目前庫存：{{ element.stock }}
			                                        </td>
		                                    	</div>
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
		                                    </tr>
		                                </template>
                                        <template #footer v-if="localItems.length === 0">
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                                    目前這個種類沒有資料
                                                </td>
                                            </tr>
                                        </template>
		                        </Draggable>
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
import ManageButton from '@/Pages/ManageButton.vue';
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

const newOrder = ref([]); //如果沒拖曳半次就送出會送出空串列

//重新進一次controller再跑一次(可能多帶個get參數)
const onChange = () => {
  router.get(route('productManage.item.index'), { categoryId: selectedId.value }, {
    preserveScroll: true, //是否滾動
    preserveState: true, //響應式變數是否留存
    replace: true, // 可選，避免新增歷史紀錄
  })
}
// 用get參數控制後端所傳的資料(只傳get參數標明的類別資料)	
// 監聽 props.items 變化並同步到本地副本localItems
watch(() => props.items, (newItems) => {
  localItems.value = [...newItems];
}, { deep: true });
//如果不用監聽改用computed的get and set，這樣會害localItems變成唯讀(因為拖曳順序會改變localItems裡array的順序)，不然就要撰寫set內容

// 是否可拖曳
const isDraggable = ref(false);

// 每拖曳完成一次後儲存新順序，按結束按鈕後isDraggable=false，儲存最終順序送ajax到後端
function saveNewOrder() {
  // localItems.value 已經是最新順序，因為v-model
  newOrder.value = [...localItems.value].map((item, index) => ({
    id: item.id,
    sort: index + 1, 
  }))
  console.log('儲存的新順序:', newOrder.value)
}

function savesort() {
  //結束拖曳，順序儲存進資料庫
  isDraggable.value = false;
  axios.post(route('productManage.item.ajax'), newOrder.value,{
  	params:{action:'sort'}
  })
    .then(response => {
      if (response.data.success) {
      	newOrder.value.length = 0;
        Swal.fire({
          title: '成功！',
          text: response.data.message,
          icon: 'success',
          confirmButtonText: '確定'
        });
      }else{
      	Swal.fire({
      	  title: '失敗！',
          text: response.data.errors,
          icon: 'error',
          confirmButtonText: '確定'
      	})
      }
    })
}

//修改進表單修改
function editItem(itemId) {
    router.get(route('productManage.item.edit', itemId));
}

//啟用與否開關
function switchVisible(itemId) {
    axios.post(route('productManage.item.ajax'), {id: itemId},{params:{action:'switchVisible'}})
    .then(response => {
        if (response.data.success) {
            Swal.fire({
                title: '成功！',
                text: response.data.message,
                icon: 'success',
                confirmButtonText: '確定'
            });
            //location.href = location.href; 等網頁刷新太慢了
            onChange(); //自動刷新重新讀資料庫
        } else {
        	Swal.fire({
	            title: '失敗！',
	            text: response.data.errors,
	            icon: 'error',
	            confirmButtonText: '確定'
	        });
        }
    })  
}

const stockInputs = ref([]) // 存放所有 input DOM
//增減庫存量
function updateStock(itemId,index) {
    axios.post(route('productManage.item.ajax'), {
        id: itemId,
        stock: stockInputs.value[index]?.value},{params:{action:'updateStock'}})
    .then(response => {
        if (response.data.success) {
            Swal.fire({
                title: '成功！',
                text: response.data.message,
                icon: 'success',
                confirmButtonText: '確定'
            });
            onChange();
        }else{
        	Swal.fire({
	            title: '失敗！',
	            text: response.data.errors,
	            icon: 'error',
	            confirmButtonText: '確定'
        });
        }
    })
}

// 刪除項目的方法
function deleteItem(itemId,itemName) {
    Swal.fire({
        title: '確定要刪除'+itemName+'嗎？',
        text: '此操作無法復原！',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '確定刪除',
        cancelButtonText: '取消'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('productManage.item.destroy', itemId), {
                onSuccess: (page) => {
                    const successMessage = page.props.flash?.success;
                    if (successMessage) {
                        Swal.fire({
                            title: '已刪除！',
                            text: successMessage,
                            icon: 'success',
                            confirmButtonText: '確定'
                        });
                    }
                },
                onError: (errors) => {
                    const errorMessage = errors.error || '刪除失敗，請稍後再試。';
                    Swal.fire({
                        title: '錯誤！',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: '確定'
                    });
                }
            });
        }
    });
}
</script>

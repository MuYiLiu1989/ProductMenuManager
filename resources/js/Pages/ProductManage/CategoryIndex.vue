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
                            <h2 class="text-2xl font-bold text-gray-800">種類管理</h2>
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
                                    @click="savetoAjax" 
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
                                        <th class="w-16 px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            種類名
                                        </th>
                                        <th class="w-20 px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            修改
                                        </th>
                                        <th class="w-20 px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                            刪除
                                        </th>
                                    </tr>
                                </thead>
                                <Draggable
                                      v-model="localCategories"
                                      item-key="id"
                                      :disabled="!isDraggable"
                                      tag="tbody"
                                      class="bg-white divide-y divide-gray-200"
                                      @end="saveNewOrder"
								    >
									    <template #item="{ element, index }">
		                                    <tr class="hover:bg-gray-50 transition-colors duration-200" :style="{ cursor: isDraggable ? 'move' : 'default' }">
		                                        <td class="w-16 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
		                                            {{ element.id }}
		                                        </td>
		                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
		                                            {{ element.name }}
		                                        </td>
		                                        <td class="w-20 px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <button @click="editCategory(element.id)" :disabled="isDraggable" class="bg-blue-500 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200">
		                                            修改
                                                    </button>
		                                        </td>
		                                        <td class="w-20 px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <button @click="deleteCategory(element.id)" :disabled="isDraggable" class="bg-red-500 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded inline-block transition-colors duration-200">
		                                            刪除
                                                    </button>
		                                        </td>
		                                    </tr>
		                                </template>
                                        <template #footer v-if="localCategories.length === 0">
                                            <tr>
                                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                                    目前沒有任何種類資料
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
    }
});

const newOrder = ref([]);

// 創建本地響應式副本用於拖曳
const localCategories = ref([...props.categories]);

// 監聽 props.categories 變化並同步到本地副本
watch(() => props.categories, (newCategories) => {
  localCategories.value = [...newCategories];
}, { deep: true });

function editCategory(categoryId) {
    router.get(route('productManage.category.edit', categoryId));
}

// 是否可拖曳
const isDraggable = ref(false);

// 拖曳完成後儲存新順序
function saveNewOrder() {
  // localCategories.value 已經是最新順序
  newOrder.value = [...localCategories.value].map((item, index) => ({
    id: item.id,
    sort: index + 1, // 或 index
  }))
  console.log('儲存的新順序:', newOrder.value)
}

function savetoAjax() {
    isDraggable.value = false;
  // 你可以在這裡發送到後端，例如 axios.post('/api/update-order', newOrder)
  axios.post(route('productManage.category.ajax'), newOrder.value)
    .then(response => {
      if (response.data.success) {
        Swal.fire({
          title: '成功！',
          text: response.data.message,
          icon: 'success',
          confirmButtonText: '確定'
        });
      }
    })
    .catch(error => {
      console.error('儲存失敗:', error);
      Swal.fire({
        title: '錯誤！',
        text: '儲存失敗，請稍後再試。',
        icon: 'error',
        confirmButtonText: '確定'
      });
    });
}

// 刪除種類的方法
function deleteCategory(categoryId) {
    Swal.fire({
        title: '確定要刪除嗎？',
        text: '此操作無法復原！',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '確定刪除',
        cancelButtonText: '取消'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('productManage.category.destroy', categoryId), {
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

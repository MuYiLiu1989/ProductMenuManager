<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ManageButton from '@/Pages/ManageButton.vue';
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3';
import { onUpdated, computed } from 'vue';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';

// 定義 props
const props = defineProps({
    item: {
        type: Object,
        default: null
    },
    categories: {
        type: Array,
        default: []
    }
});

// 判斷是否為編輯模式
const isEditing = computed(() => props.item !== null);

const form = useForm({
  name: props.item?.name || '',
  category_id: props.item?.category_id || '',
  price: props.item?.price || '',
  stock: props.item?.stock || '',
  is_visible: props.item?.is_visible || '0'
})



//從onMounted改成onUpdated就成功了
/*
onUpdated(() => {
	console.log("Updated!");
    const flashSuccess = Pages.props.flash?.success;
    // 檢查是否有成功訊息需要顯示
    if (flashSuccess) {
        Swal.fire({
                title: '成功！',
                text: flashSuccess,
                icon: 'success',
                confirmButtonText: '確定'
            });
        if (!isEditing.value) {
            form.reset();
        }
    }
});
*/

// 處理表單提交
const submitForm = () => {
    if (isEditing.value) {
        // 編輯模式：使用 PUT 方法更新
        form.put(`/productManage/item/${props.item.id}`, {
        	onSuccess: (page) => {
        		handleFormSuccess(page);
        	},
            onError: (errors) => {
                handleFormError(errors);
            }
        });
    } else {
        // 新增模式：使用 POST 方法
        form.post('/productManage/item', {
        	onSuccess: (page) => {
        		handleFormSuccess(page);
        		form.reset();
        	},
            onError: (errors) => {
                handleFormError(errors);
            }
        });
    }
};

// 處理表單成功
const handleFormSuccess = (page) => {
	//const Pages = usePage();
	const flashSuccess = page.props.flash?.success;
	Swal.fire({
        title: '成功！',
        text: flashSuccess,
        icon: 'success',
        confirmButtonText: '確定'
    });
}

// 處理表單錯誤
const handleFormError = (errors) => {
    let errorMessage = '請檢查輸入的資料';
    if (errors.name) {
        errorMessage = errors.name;
    }else if(errors.category_id){
    	errorMessage = errors.category_id;
    }else if(errors.price){
    	errorMessage = errors.price;
    }else if(errors.stock){
    	errorMessage = errors.stock;
    }
    
    Swal.fire({
        title: '錯誤！',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: '確定'
    });
};


</script>

<template>
    <Head title="productManageItemForm" />

    <AuthenticatedLayout>
        <template #header>
            <ManageButton></ManageButton>
        </template>

        <div class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white text-gray-900">
                        <form @submit.prevent="submitForm">
                            <h2 class="text-xl font-bold text-gray-800 mb-6">
                                {{ isEditing ? '編輯項目' : '新增項目' }}
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <fieldset class="mb-4">
                                    <legend class="text-lg font-semibold text-gray-800 mb-2">項目名：</legend>
                                    <input 
                                        type="text" 
                                        class="w-full px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        v-model="form.name" 
                                        placeholder="請輸入項目名" 
                                    />
                                    <span v-if="form.errors.name" class="text-red-500 text-sm mt-1 block">{{ form.errors.name }}</span>    
                                </fieldset>
                                <fieldset class="mb-4">
                                    <legend class="text-lg font-semibold text-gray-800 mb-2">類別：</legend>
                                    <select  
                                        class="w-full px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        v-model="form.category_id" 
                                    >
                                        <option value="">請選擇類別</option>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.name}}</option>
                                    </select>
                                    <span v-if="form.errors.category_id" class="text-red-500 text-sm mt-1 block">{{ form.errors.category_id }}</span>    
                                </fieldset>
                                <fieldset class="mb-4">
                                    <legend class="text-lg font-semibold text-gray-800 mb-2">價格：</legend>
                                    <input 
                                        type="number"
                                        min='0' step='1' 
                                        class="w-full px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        v-model="form.price" 
                                        placeholder="請輸入價格" 
                                    />
                                    <span v-if="form.errors.price" class="text-red-500 text-sm mt-1 block">{{ form.errors.price }}</span>    
                                </fieldset>
                                <fieldset class="mb-4">
                                    <legend class="text-lg font-semibold text-gray-800 mb-2">庫存量：</legend>
                                    <input 
                                        type="number" 
                                        min='0' step='1'
                                        class="w-full px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        v-model="form.stock" 
                                        placeholder="請輸入庫存" 
                                    />
                                    <span v-if="form.errors.stock" class="text-red-500 text-sm mt-1 block">{{ form.errors.stock }}</span>    
                                </fieldset>
                                <fieldset class="mb-4">
                                    <legend class="text-lg font-semibold text-gray-800 mb-2">是否啟用：</legend>
                                    <input 
                                        type="radio" 
                                        class="w-8 px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500" 
                                        v-model="form.is_visible"
                                        value="0"  
                                    />不啟用
                                    <input 
                                        type="radio" 
                                        class="w-8 px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none  focus:ring-blue-500" 
                                        v-model="form.is_visible"
                                        value="1"  
                                    />啟用
                                    <!-- focus:ring-2 矩形外框 -->
                                    <span v-if="form.errors.is_visible" class="text-red-500 text-sm mt-1 block">{{ form.errors.is_visible }}</span>    
                                </fieldset>
                                <!--
                                <h2 v-if="isEditing && props.item.sort==0">
                                    排序未更新
                                </h2>
                                針對無sort值的項目來建立其sort值，現在已經不需要了，因為項目在新增的時候就建立好sort值了
                            	-->
	                            <div class="flex gap-3 my-6 mx-2 justify-end">
	                            	<!--原本是mt-6，新增跟取消上下變很大，取消沒上下置中-->
	                                <button 
	                                    type="submit" 
	                                    :disabled="form.processing"
	                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
	                                >
	                                    {{ isEditing ? '更新' : '新增' }}
	                                </button>
	                                <Link 
	                                    :href="route('productManage.item.index', { categoryId: form.category_id })"
	                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
	                                >
	                                    取消
	                                </Link>
	                                <!-- 按取消可以維持原本的類別選項 -->
	                            </div>
                        	</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

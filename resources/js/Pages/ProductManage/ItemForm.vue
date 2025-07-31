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
  category: props.item?.category || '',
  price: props.item?.price || '',
  stock: props.item?.stock || '',
})


const Pages = usePage()
//從onMounted改成onUpdated就成功了
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

// 處理表單提交
const submitForm = () => {
    if (isEditing.value) {
        // 編輯模式：使用 PUT 方法更新
        form.put(`/productManage/item/${props.item.id}`, {
            onError: (errors) => {
                handleFormError(errors);
            }
        });
    } else {
        // 新增模式：使用 POST 方法
        form.post('/productManage/item', {
            onError: (errors) => {
                handleFormError(errors);
            }
        });
    }
};

// 處理表單錯誤
const handleFormError = (errors) => {
    let errorMessage = '請檢查輸入的資料';
    if (errors.name) {
        errorMessage = errors.name;
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
                                        v-model="form.category" 
                                    >
                                        <option value="">請選擇類別</option>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.name}}</option>
                                    </select>
                                    <span v-if="form.errors.category" class="text-red-500 text-sm mt-1 block">{{ form.errors.category }}</span>    
                                </fieldset>
                                <fieldset class="mb-4">
                                    <legend class="text-lg font-semibold text-gray-800 mb-2">價格：</legend>
                                    <input 
                                        type="number" 
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
                                        class="w-full px-3 py-2 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        v-model="form.stock" 
                                        placeholder="請輸入庫存" 
                                    />
                                    <span v-if="form.errors.stock" class="text-red-500 text-sm mt-1 block">{{ form.errors.stock }}</span>    
                                </fieldset>
                            </div>
                            <div class="flex gap-2 mt-6">
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                                >
                                    {{ isEditing ? '更新' : '新增' }}
                                </button>
                                <Link 
                                    :href="route('productManage.category.index')"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    取消
                                </Link>
                            </div>
                        </form>
                        <div v-if="form.name" class="mt-4">
                            <p class="text-gray-800">預覽：{{ form.name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

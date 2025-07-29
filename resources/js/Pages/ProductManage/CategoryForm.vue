<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ManageButton from '@/Pages/ManageButton.vue';
import { useForm } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3';
import { onUpdated } from 'vue';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';

const form = useForm({
  name: '',
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
        form.reset();
    }
});

// 處理表單提交
const submitForm = () => {
    form.post('/productManage/category', {
        onError: (errors) => {
            // 錯誤時顯示 SweetAlert
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
        }
    });
};


</script>

<template>
    <Head title="productManage" />

    <AuthenticatedLayout>
        <template #header>
            <ManageButton></ManageButton>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submitForm">
                            <fieldset class="mb-4">
                                <legend class="text-lg font-semibold text-gray-800 mb-2">種類名：</legend>
                                <input 
                                    type="text" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                    v-model="form.name" 
                                    placeholder="請輸入種類名" 
                                />
                                <span v-if="form.errors.name" class="text-red-500 text-sm mt-1 block">{{ form.errors.name }}</span>    
                            </fieldset>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                            >
                                送出
                            </button>
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

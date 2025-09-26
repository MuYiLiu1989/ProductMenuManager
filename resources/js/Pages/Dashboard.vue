<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { onMounted} from 'vue';
import Swal from 'sweetalert2';

onMounted(() => {
	console.log("Mounted!");
	const Pages = usePage();
    const flashSuccess = Pages.props.flash?.message;
    // 檢查是否有成功訊息需要顯示
    console.log(flashSuccess);
    if (flashSuccess) {
        Swal.fire({
            title: 'Oh No！',
            text: flashSuccess,
            icon: 'error',
            confirmButtonText: '確定'
        });
    }
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in! Welcome to my ProductMenu System!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

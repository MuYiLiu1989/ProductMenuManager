<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from "vue";

const buttons = [
	{"label" : "類別總覽", "name" : "productManage.category.index", "url" : route("productManage.category.index")},
    {"label" : "類別新增", "name" : "productManage.category.create", "url" : route("productManage.category.create")},
    {"label" : "項目總覽", "name" : "productManage.item.index", "url" : route("productManage.item.index")},
    {"label" : "項目新增", "name" : "productManage.item.create", "url" : route("productManage.item.create")}
];
const activeIndex = ref('');
</script>
<template>
  <div class="flex space-x-6">
    <Link
      v-for="(btn, index) in buttons"
      :key="index"
      :href="btn.url"
      class="px-2 py-0 rounded-lg border-2 text-md font-medium transition focus:outline-none"
      :class="route().current(btn.name)
        ? 'border-blue-500 ring ring-blue-300 bg-blue-50 text-blue-700'
        : 'border-transparent hover:border-gray-400 text-gray-700'"
    >
      {{ btn.label }}
    </Link>
  </div>	
</template>
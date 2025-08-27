<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from "vue";

const buttons = [
	{"label" : "menu" , "name" : "productOrder.menu" , "url" : route('productOrder.menu')},
	{"label" : "cart" , "name" : "productOrder.cart" , "url" : route('productOrder.cart')},
	{"label" : "orderlist" , "name" : "productOrder.orderlist" , "url" : route('productOrder.orderlist')}
]
const activeIndex = ref('');
</script>
<template>
	<div class="flex space-x-6">
    <Link
      v-for="(btn, index) in buttons"
      :key="index"
      :href="btn.url"
      class="px-2 py-0 rounded-lg border-2 text-lg font-medium transition focus:outline-none"
      :class="route().current(btn.name)
        ? 'border-blue-500 ring ring-blue-300 bg-blue-50 text-blue-700'
        : 'border-transparent hover:border-gray-400 text-gray-700'"
    >
      {{ btn.label }}
    </Link>
  </div>	
</template>
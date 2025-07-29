<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
	<Link :href="route('productManage.category.index')">
        <button class="btn">category總覽</button>
    </Link>
    <Link :href="route('productManage.category.create')">
        <button class="btn">category新增</button>
    </Link>
    <Link :href="route('productManage.item.index')">
        <button class="btn">item總覽</button>
    </Link>
    <Link :href="route('productManage.item.create')">
        <button class="btn">item新增</button>
    </Link>
</template>
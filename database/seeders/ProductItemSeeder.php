<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_items')->truncate();
        DB::table('product_items')->Insert([
		  array('is_enable' => '1','is_visible' => '1','id' => '3','name' => '王子麵','category_id' => '50','stock' => '30','price' => '10','sort' => '1','updated_at' => '2025-08-10 10:35:24','created_at' => '2025-08-05 08:13:58'),
		  array('is_enable' => '1','is_visible' => '1','id' => '4','name' => '麥穗餅乾(包)','category_id' => '50','stock' => '46','price' => '78','sort' => '2','updated_at' => '2025-08-10 10:35:24','created_at' => '2025-08-05 08:14:48'),
		  array('is_enable' => '1','is_visible' => '1','id' => '5','name' => '洗髮精','category_id' => '39','stock' => '34','price' => '200','sort' => '2','updated_at' => '2025-08-12 02:40:25','created_at' => '2025-08-05 08:15:09'),
		  array('is_enable' => '1','is_visible' => '1','id' => '6','name' => '沐浴乳','category_id' => '39','stock' => '43','price' => '220','sort' => '1','updated_at' => '2025-08-08 09:36:16','created_at' => '2025-08-05 08:15:36'),
		  array('is_enable' => '1','is_visible' => '1','id' => '7','name' => '衛生紙(包)','category_id' => '39','stock' => '45','price' => '20','sort' => '5','updated_at' => '2025-08-12 02:43:33','created_at' => '2025-08-05 08:16:25'),
		  array('is_enable' => '1','is_visible' => '1','id' => '8','name' => '廚房紙巾(包)','category_id' => '44','stock' => '45','price' => '25','sort' => '8','updated_at' => '2025-08-08 03:14:27','created_at' => '2025-08-05 08:17:43'),
		  array('is_enable' => '1','is_visible' => '1','id' => '9','name' => '電視機','category_id' => '48','stock' => '4','price' => '9999','sort' => '1','updated_at' => '2025-08-08 09:45:48','created_at' => '2025-08-05 08:18:22'),
		  array('is_enable' => '1','is_visible' => '1','id' => '10','name' => '電冰箱','category_id' => '48','stock' => '3','price' => '20000','sort' => '6','updated_at' => '2025-08-08 09:45:48','created_at' => '2025-08-05 08:18:47'),
		  array('is_enable' => '1','is_visible' => '1','id' => '11','name' => '跳舞紅茶','category_id' => '51','stock' => '46','price' => '15','sort' => '3','updated_at' => '2025-08-08 03:09:42','created_at' => '2025-08-05 08:19:11'),
		  array('is_enable' => '1','is_visible' => '1','id' => '12','name' => '跳舞綠茶','category_id' => '51','stock' => '50','price' => '15','sort' => '4','updated_at' => '2025-08-12 02:10:17','created_at' => '2025-08-05 08:19:31'),
		  array('is_enable' => '1','is_visible' => '1','id' => '13','name' => '礦泉水','category_id' => '51','stock' => '42','price' => '12','sort' => '1','updated_at' => '2025-08-12 02:09:31','created_at' => '2025-08-05 08:19:57'),
		  array('is_enable' => '1','is_visible' => '1','id' => '14','name' => '開喜烏龍茶','category_id' => '51','stock' => '43','price' => '25','sort' => '2','updated_at' => '2025-08-12 02:10:09','created_at' => '2025-08-05 08:20:17'),
		  array('is_enable' => '1','is_visible' => '1','id' => '15','name' => '冷氣機','category_id' => '48','stock' => '2','price' => '30000','sort' => '2','updated_at' => '2025-08-11 09:00:23','created_at' => '2025-08-05 08:20:37'),
		  array('is_enable' => '1','is_visible' => '1','id' => '16','name' => '冷凍水餃(包)','category_id' => '40','stock' => '34','price' => '80','sort' => '1','updated_at' => '2025-08-08 03:11:37','created_at' => '2025-08-05 08:21:05'),
		  array('is_enable' => '1','is_visible' => '1','id' => '17','name' => '冷凍雞塊','category_id' => '40','stock' => '42','price' => '150','sort' => '3','updated_at' => '2025-08-08 03:11:55','created_at' => '2025-08-05 08:21:32'),
		  array('is_enable' => '1','is_visible' => '1','id' => '18','name' => '冷凍薯條','category_id' => '40','stock' => '34','price' => '100','sort' => '2','updated_at' => '2025-08-08 03:11:46','created_at' => '2025-08-05 08:21:51'),
		  array('is_enable' => '1','is_visible' => '1','id' => '19','name' => 'iphone手機','category_id' => '49','stock' => '25','price' => '30000','sort' => '4','updated_at' => '2025-08-12 07:59:11','created_at' => '2025-08-05 08:22:22'),
		  array('is_enable' => '1','is_visible' => '1','id' => '20','name' => 'type充電線','category_id' => '49','stock' => '44','price' => '150','sort' => '1','updated_at' => '2025-08-12 08:07:23','created_at' => '2025-08-05 08:22:47'),
		  array('is_enable' => '1','is_visible' => '1','id' => '21','name' => '隨身充','category_id' => '49','stock' => '34','price' => '699','sort' => '2','updated_at' => '2025-08-12 07:59:11','created_at' => '2025-08-05 08:23:09'),
		  array('is_enable' => '1','is_visible' => '1','id' => '22','name' => '原子筆','category_id' => '47','stock' => '39','price' => '10','sort' => '1','updated_at' => '2025-08-11 09:49:33','created_at' => '2025-08-05 08:23:47'),
		  array('is_enable' => '1','is_visible' => '1','id' => '23','name' => '尺','category_id' => '47','stock' => '42','price' => '10','sort' => '11','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:24:13'),
		  array('is_enable' => '1','is_visible' => '1','id' => '24','name' => '塑膠墊板','category_id' => '47','stock' => '43','price' => '10','sort' => '9','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:24:34'),
		  array('is_enable' => '1','is_visible' => '1','id' => '25','name' => '橡皮擦','category_id' => '47','stock' => '43','price' => '5','sort' => '8','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:24:52'),
		  array('is_enable' => '1','is_visible' => '1','id' => '26','name' => '自動鉛筆','category_id' => '47','stock' => '54','price' => '20','sort' => '7','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:25:22'),
		  array('is_enable' => '1','is_visible' => '1','id' => '27','name' => '手機吊飾','category_id' => '45','stock' => '45','price' => '100','sort' => '3','updated_at' => '2025-08-08 03:15:27','created_at' => '2025-08-05 08:25:44'),
		  array('is_enable' => '1','is_visible' => '1','id' => '28','name' => '紀念鑰匙圈','category_id' => '45','stock' => '45','price' => '100','sort' => '4','updated_at' => '2025-08-08 03:15:36','created_at' => '2025-08-05 08:26:04'),
		  array('is_enable' => '1','is_visible' => '1','id' => '29','name' => '紀念幣','category_id' => '45','stock' => '54','price' => '100','sort' => '6','updated_at' => '2025-08-08 03:15:57','created_at' => '2025-08-05 08:26:21'),
		  array('is_enable' => '1','is_visible' => '1','id' => '30','name' => '造型扇子','category_id' => '45','stock' => '44','price' => '50','sort' => '5','updated_at' => '2025-08-08 03:15:45','created_at' => '2025-08-05 08:27:04'),
		  array('is_enable' => '1','is_visible' => '1','id' => '31','name' => '鉛筆盒','category_id' => '47','stock' => '34','price' => '100','sort' => '10','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:27:24'),
		  array('is_enable' => '1','is_visible' => '1','id' => '32','name' => '筆記本','category_id' => '47','stock' => '53','price' => '20','sort' => '5','updated_at' => '2025-08-11 08:14:29','created_at' => '2025-08-05 08:27:43'),
		  array('is_enable' => '1','is_visible' => '1','id' => '33','name' => '記事本','category_id' => '47','stock' => '45','price' => '20','sort' => '4','updated_at' => '2025-08-11 08:15:45','created_at' => '2025-08-05 08:28:03'),
		  array('is_enable' => '1','is_visible' => '1','id' => '34','name' => '洗衣機','category_id' => '48','stock' => '4','price' => '30000','sort' => '4','updated_at' => '2025-08-11 08:49:41','created_at' => '2025-08-05 08:29:27'),
		  array('is_enable' => '1','is_visible' => '1','id' => '35','name' => '樂高積木','category_id' => '52','stock' => '43','price' => '300','sort' => '1','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:30:03'),
		  array('is_enable' => '1','is_visible' => '1','id' => '36','name' => '七巧板','category_id' => '52','stock' => '43','price' => '200','sort' => '3','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:30:23'),
		  array('is_enable' => '1','is_visible' => '1','id' => '37','name' => '大富翁','category_id' => '52','stock' => '32','price' => '150','sort' => '6','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:30:42'),
		  array('is_enable' => '1','is_visible' => '1','id' => '38','name' => '跳棋','category_id' => '52','stock' => '34','price' => '150','sort' => '7','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:31:09'),
		  array('is_enable' => '1','is_visible' => '1','id' => '39','name' => '魔術方塊','category_id' => '52','stock' => '32','price' => '150','sort' => '4','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:31:44'),
		  array('is_enable' => '1','is_visible' => '1','id' => '40','name' => '寶可夢圖卡','category_id' => '52','stock' => '455','price' => '20','sort' => '2','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:32:05'),
		  array('is_enable' => '1','is_visible' => '1','id' => '41','name' => '玩具火車鐵軌','category_id' => '52','stock' => '34','price' => '500','sort' => '8','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:33:05'),
		  array('is_enable' => '1','is_visible' => '1','id' => '42','name' => '鋼琴模型','category_id' => '45','stock' => '34','price' => '200','sort' => '2','updated_at' => '2025-08-08 03:15:18','created_at' => '2025-08-05 08:34:02'),
		  array('is_enable' => '1','is_visible' => '1','id' => '43','name' => 'USB隨身碟','category_id' => '49','stock' => '32','price' => '300','sort' => '3','updated_at' => '2025-08-12 08:08:00','created_at' => '2025-08-05 08:34:26'),
		  array('is_enable' => '1','is_visible' => '1','id' => '44','name' => '書套','category_id' => '47','stock' => '34','price' => '10','sort' => '3','updated_at' => '2025-08-11 08:32:16','created_at' => '2025-08-05 08:35:13'),
		  array('is_enable' => '1','is_visible' => '1','id' => '45','name' => '書籤','category_id' => '47','stock' => '56','price' => '5','sort' => '6','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:35:31'),
		  array('is_enable' => '1','is_visible' => '1','id' => '46','name' => '城堡造型存錢筒','category_id' => '45','stock' => '34','price' => '300','sort' => '7','updated_at' => '2025-08-08 03:16:06','created_at' => '2025-08-05 08:36:15'),
		  array('is_enable' => '1','is_visible' => '1','id' => '47','name' => '膠帶','category_id' => '47','stock' => '43','price' => '10','sort' => '2','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:36:40'),
		  array('is_enable' => '1','is_visible' => '1','id' => '48','name' => '球球','category_id' => '52','stock' => '33','price' => '100','sort' => '5','updated_at' => '2025-08-08 10:30:41','created_at' => '2025-08-05 08:37:15'),
		  array('is_enable' => '1','is_visible' => '1','id' => '49','name' => '護髮素','category_id' => '39','stock' => '43','price' => '180','sort' => '4','updated_at' => '2025-08-12 02:37:03','created_at' => '2025-08-05 08:38:49'),
		  array('is_enable' => '1','is_visible' => '1','id' => '50','name' => '潤髮乳','category_id' => '39','stock' => '43','price' => '220','sort' => '3','updated_at' => '2025-08-12 02:46:41','created_at' => '2025-08-05 08:39:11'),
		  array('is_enable' => '1','is_visible' => '1','id' => '51','name' => '地球儀','category_id' => '45','stock' => '43','price' => '300','sort' => '1','updated_at' => '2025-08-08 03:15:07','created_at' => '2025-08-05 08:39:37'),
		  array('is_enable' => '1','is_visible' => '1','id' => '52','name' => '文件夾','category_id' => '47','stock' => '43','price' => '10','sort' => '12','updated_at' => '2025-08-11 03:07:12','created_at' => '2025-08-05 08:40:08'),
		  array('is_enable' => '1','is_visible' => '1','id' => '53','name' => '洗碗精','category_id' => '44','stock' => '32','price' => '150','sort' => '7','updated_at' => '2025-08-08 03:14:12','created_at' => '2025-08-05 08:40:38'),
		  array('is_enable' => '1','is_visible' => '1','id' => '54','name' => '油壺','category_id' => '44','stock' => '34','price' => '50','sort' => '9','updated_at' => '2025-08-08 03:14:39','created_at' => '2025-08-05 08:41:01'),
		  array('is_enable' => '1','is_visible' => '1','id' => '55','name' => '鹽巴(盒)','category_id' => '44','stock' => '34','price' => '50','sort' => '2','updated_at' => '2025-08-08 03:13:00','created_at' => '2025-08-05 08:41:31'),
		  array('is_enable' => '1','is_visible' => '1','id' => '56','name' => '食用油','category_id' => '44','stock' => '38','price' => '200','sort' => '3','updated_at' => '2025-08-11 10:12:27','created_at' => '2025-08-05 08:41:48'),
		  array('is_enable' => '1','is_visible' => '1','id' => '57','name' => '雞蛋(盒)','category_id' => '44','stock' => '34','price' => '50','sort' => '1','updated_at' => '2025-08-08 03:12:45','created_at' => '2025-08-05 08:42:19'),
		  array('is_enable' => '1','is_visible' => '1','id' => '58','name' => '平底鍋','category_id' => '44','stock' => '23','price' => '300','sort' => '11','updated_at' => '2025-08-08 03:14:55','created_at' => '2025-08-05 08:42:48'),
		  array('is_enable' => '1','is_visible' => '1','id' => '59','name' => '湯鍋','category_id' => '44','stock' => '21','price' => '200','sort' => '10','updated_at' => '2025-08-08 03:14:47','created_at' => '2025-08-05 08:43:07'),
		  array('is_enable' => '1','is_visible' => '1','id' => '60','name' => '筷子(雙)','category_id' => '44','stock' => '32','price' => '20','sort' => '6','updated_at' => '2025-08-08 03:13:59','created_at' => '2025-08-05 08:43:47'),
		  array('is_enable' => '1','is_visible' => '1','id' => '61','name' => '碗公','category_id' => '44','stock' => '32','price' => '20','sort' => '5','updated_at' => '2025-08-08 03:13:49','created_at' => '2025-08-05 08:44:04'),
		  array('is_enable' => '1','is_visible' => '1','id' => '62','name' => '湯匙','category_id' => '44','stock' => '34','price' => '20','sort' => '4','updated_at' => '2025-08-08 03:13:41','created_at' => '2025-08-05 08:44:23'),
		  array('is_enable' => '1','is_visible' => '1','id' => '63','name' => '烘碗機','category_id' => '48','stock' => '6','price' => '1000','sort' => '5','updated_at' => '2025-08-08 09:45:48','created_at' => '2025-08-05 08:44:43'),
		  array('is_enable' => '1','is_visible' => '1','id' => '64','name' => '電熱水瓶','category_id' => '48','stock' => '14','price' => '3000','sort' => '3','updated_at' => '2025-08-11 09:00:19','created_at' => '2025-08-05 08:45:09'),
		  array('is_enable' => '1','is_visible' => '1','id' => '66','name' => '書桌','category_id' => '53','stock' => '53','price' => '2000','sort' => '1','updated_at' => '2025-08-12 08:01:08','created_at' => '2025-08-12 08:01:08'),
		  array('is_enable' => '1','is_visible' => '1','id' => '67','name' => '餐桌','category_id' => '53','stock' => '23','price' => '3000','sort' => '2','updated_at' => '2025-08-12 08:01:48','created_at' => '2025-08-12 08:01:48'),
		  array('is_enable' => '1','is_visible' => '1','id' => '68','name' => '椅子','category_id' => '53','stock' => '23','price' => '500','sort' => '3','updated_at' => '2025-08-12 08:02:07','created_at' => '2025-08-12 08:02:07'),
		  array('is_enable' => '1','is_visible' => '1','id' => '69','name' => '床組','category_id' => '53','stock' => '3','price' => '10000','sort' => '4','updated_at' => '2025-08-12 08:02:29','created_at' => '2025-08-12 08:02:29'),
		  array('is_enable' => '1','is_visible' => '1','id' => '70','name' => '床頭櫃','category_id' => '53','stock' => '6','price' => '5000','sort' => '5','updated_at' => '2025-08-12 08:02:52','created_at' => '2025-08-12 08:02:52'),
		  array('is_enable' => '1','is_visible' => '1','id' => '71','name' => '書櫃','category_id' => '53','stock' => '13','price' => '1000','sort' => '6','updated_at' => '2025-08-12 08:03:08','created_at' => '2025-08-12 08:03:08'),
		  array('is_enable' => '1','is_visible' => '1','id' => '72','name' => '衣櫃','category_id' => '53','stock' => '21','price' => '1000','sort' => '7','updated_at' => '2025-08-12 08:03:29','created_at' => '2025-08-12 08:03:29'),
		  array('is_enable' => '1','is_visible' => '1','id' => '73','name' => '冷凍牛小排','category_id' => '40','stock' => '43','price' => '1000','sort' => '4','updated_at' => '2025-08-12 08:04:19','created_at' => '2025-08-12 08:04:19'),
		  array('is_enable' => '1','is_visible' => '1','id' => '74','name' => '冷凍鯛魚','category_id' => '40','stock' => '45','price' => '100','sort' => '5','updated_at' => '2025-08-12 08:04:38','created_at' => '2025-08-12 08:04:38'),
		  array('is_enable' => '1','is_visible' => '1','id' => '75','name' => '冷凍虱目魚','category_id' => '40','stock' => '45','price' => '100','sort' => '6','updated_at' => '2025-08-12 08:04:55','created_at' => '2025-08-12 08:04:55'),
		  array('is_enable' => '1','is_visible' => '1','id' => '76','name' => '牙刷','category_id' => '39','stock' => '45','price' => '20','sort' => '6','updated_at' => '2025-08-12 08:05:42','created_at' => '2025-08-12 08:05:42'),
		  array('is_enable' => '1','is_visible' => '1','id' => '77','name' => '牙膏','category_id' => '39','stock' => '34','price' => '150','sort' => '7','updated_at' => '2025-08-12 08:06:00','created_at' => '2025-08-12 08:06:00'),
		  array('is_enable' => '1','is_visible' => '1','id' => '78','name' => '吹風機','category_id' => '39','stock' => '24','price' => '350','sort' => '8','updated_at' => '2025-08-12 08:06:22','created_at' => '2025-08-12 08:06:22'),
		  array('is_enable' => '1','is_visible' => '1','id' => '79','name' => '計算機','category_id' => '49','stock' => '45','price' => '200','sort' => '5','updated_at' => '2025-08-12 08:08:50','created_at' => '2025-08-12 08:08:50'),
		  array('is_enable' => '1','is_visible' => '1','id' => '80','name' => '巧克力棒','category_id' => '50','stock' => '56','price' => '30','sort' => '3','updated_at' => '2025-08-12 08:09:49','created_at' => '2025-08-12 08:09:49'),
		  array('is_enable' => '1','is_visible' => '1','id' => '81','name' => '巧克力塊','category_id' => '50','stock' => '45','price' => '150','sort' => '4','updated_at' => '2025-08-12 08:10:37','created_at' => '2025-08-12 08:10:37'),
		  array('is_enable' => '1','is_visible' => '1','id' => '82','name' => 'mm巧克力(包)','category_id' => '50','stock' => '56','price' => '150','sort' => '5','updated_at' => '2025-08-12 08:11:07','created_at' => '2025-08-12 08:11:07'),
		  array('is_enable' => '1','is_visible' => '1','id' => '83','name' => '氣泡水','category_id' => '51','stock' => '54','price' => '30','sort' => '5','updated_at' => '2025-08-12 08:12:07','created_at' => '2025-08-12 08:12:07')
        ]);
    }
}

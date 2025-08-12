<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->delete();
        DB::table('product_categories')->Insert([
            array('is_enable' => '1','is_visible' => '1','id' => '39','name' => '衛浴用品','sort' => '5','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-29 11:14:56'),
		    array('is_enable' => '1','is_visible' => '1','id' => '40','name' => '冷凍食品','sort' => '3','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-29 11:15:08'),
		    array('is_enable' => '1','is_visible' => '1','id' => '44','name' => '廚房用品','sort' => '4','updated_at' => '2025-08-12 08:13:39','created_at' => '2025-07-30 10:53:56'),
		    array('is_enable' => '1','is_visible' => '1','id' => '45','name' => '文創紀念品','sort' => '11','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-30 10:54:24'),
		    array('is_enable' => '1','is_visible' => '1','id' => '47','name' => '文具用品','sort' => '9','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-31 08:12:41'),
		    array('is_enable' => '1','is_visible' => '1','id' => '48','name' => '家電','sort' => '6','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-31 08:15:47'),
		    array('is_enable' => '1','is_visible' => '1','id' => '49','name' => '3C產品','sort' => '7','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-31 08:16:04'),
		    array('is_enable' => '1','is_visible' => '1','id' => '50','name' => '零食餅乾','sort' => '1','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-31 08:21:49'),
		    array('is_enable' => '1','is_visible' => '1','id' => '51','name' => '飲料','sort' => '2','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-07-31 08:22:14'),
		    array('is_enable' => '1','is_visible' => '1','id' => '52','name' => '兒童玩具','sort' => '10','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-08-02 12:52:24'),
		    array('is_enable' => '1','is_visible' => '1','id' => '53','name' => '家具','sort' => '8','updated_at' => '2025-08-02 12:53:51','created_at' => '2025-08-02 12:53:33')
        ]);
    }
}

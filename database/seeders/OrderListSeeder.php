<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_lists')->truncate();
        DB::table('order_lists')->Insert([
        	array('id' => '32','user_id' => '3','created_at' => '2025-09-22 10:06:27','updated_at' => '2025-09-22 10:06:27','order' => '[{"id":83,"name":"\\u6c23\\u6ce1\\u6c34","category":51,"price":30,"quantity":4},{"id":48,"name":"\\u7403\\u7403","category":52,"price":100,"quantity":3},{"id":4,"name":"\\u9ea5\\u7a57\\u9905\\u4e7e(\\u5305)","category":50,"price":78,"quantity":3}]','price' => '654'),
  			array('id' => '22','user_id' => '3','created_at' => '2025-09-18 10:15:38','updated_at' => '2025-09-18 10:15:38','order' => '[{"id":7,"name":"\\u885b\\u751f\\u7d19(\\u5305)","category":39,"price":20,"quantity":2},{"id":14,"name":"\\u958b\\u559c\\u70cf\\u9f8d\\u8336","category":51,"price":25,"quantity":5},{"id":27,"name":"\\u624b\\u6a5f\\u540a\\u98fe","category":45,"price":100,"quantity":2}]','price' => '365'),
  			array('id' => '30','user_id' => '1','created_at' => '2025-09-20 11:40:37','updated_at' => '2025-09-20 11:40:37','order' => '[{"id":49,"name":"\\u8b77\\u9aee\\u7d20","category":39,"price":180,"quantity":1},{"id":6,"name":"\\u6c90\\u6d74\\u4e73","category":39,"price":220,"quantity":1},{"id":5,"name":"\\u6d17\\u9aee\\u7cbe","category":39,"price":200,"quantity":2}]','price' => '800'),
  			array('id' => '31','user_id' => '1','created_at' => '2025-09-20 11:42:49','updated_at' => '2025-09-20 11:42:49','order' => '[{"id":43,"name":"USB\\u96a8\\u8eab\\u789f","category":49,"price":300,"quantity":1},{"id":21,"name":"\\u96a8\\u8eab\\u5145","category":49,"price":699,"quantity":1},{"id":20,"name":"type\\u5145\\u96fb\\u7dda","category":49,"price":150,"quantity":3}]','price' => '1449'),
  			array('id' => '21','user_id' => '3','created_at' => '2025-09-18 10:04:29','updated_at' => '2025-09-18 10:04:29','order' => '[{"id":32,"name":"\\u7b46\\u8a18\\u672c","category":47,"price":20,"quantity":5},{"id":68,"name":"\\u6905\\u5b50","category":53,"price":500,"quantity":2}]','price' => '1100')
        ]);
    }
}

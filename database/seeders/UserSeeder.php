<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();//如果有被其他table引用為foreign key的話，要用delete
        //id在orderlist已經有了，這裡的id要跟orderlist裡的對上
        $user = new User([
        	'id' => 1,
            'name' => 'AdmireJustice',
            'email' => 'chenmy1989@gmail.com',
            'password' => Hash::make('JessicaTienTien'),
            'is_product_manager' => true,
        ]);
        $user->save();

        $user = new User([
        	'id' => 3,
        	'name' => 'Joyce',
        	'email' => 'linyujoyce@gmail.com',
        	'password' => Hash::make('60093811'),
        	'is_product_manager' => false,
        ]);
        $user->save();
    }
}

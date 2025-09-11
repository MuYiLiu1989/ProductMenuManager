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
        DB::table('users')->truncate();

        $user = new User([
            'name' => 'AdmireJustice',
            'email' => 'chenmy1989@gmail.com',
            'password' => Hash::make('JessicaTienTien'),
            'is_product_manager' => true,
        ]);
        $user->save();

        $user = new User([
        	'name' => '媽媽',
        	'email' => 'linyujoyce@gmail.com',
        	'password' => Hash::make('60093811'),
        	'is_product_manager' => false,
        ]);
        $user->save();
    }
}

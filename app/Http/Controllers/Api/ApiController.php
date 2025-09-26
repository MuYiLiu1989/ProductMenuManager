<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;
use App\Mail\TokenMail;
use App\Models\ProductCategory;

class ApiController extends Controller
{
    public function getToken(Request $request)
    {
    	$tokentype = $request->tokentype;
    	$user = $request->user();//必須加上web的middleware才可以取得user model
    	$exipire_at = new DateTime();
        $exipire_at->add(new DateInterval('PT1H'));
        $accessToken = $user->createToken('api-token', [$tokentype], $exipire_at)->plainTextToken;
        //token的type當作token的ability
        $query = PersonalAccessToken::where('tokenable_type', 'App\Models\User')->where('tokenable_id', $user->id);
        $query->whereNotIn('id', (clone $query)->orderByDesc('created_at')->take(5)->pluck('id'))->delete();
        //針對資料庫中某個user_id的token只取最新的五個，其餘的刪除
        try{
    	Mail::to($user->email)->send(new TokenMail($tokentype,$accessToken));
    	}catch(\Exception $e){
    		dd($e->getMessage());
    	}

    	return response()->json(['status'=>true,'message'=>"{$tokentype}的token信件已成功寄出！"]);
    }

    public function route()
    {
        $routeCollection = Route::getRoutes();
        //display所有的api路由
        echo "<table style='margin:0 auto; text-align:center; font-size:larger;' border='1'>";
        echo '<tr>';
        echo "<th>HTTP Method</th>";
        echo '<th>Route</th>';
        echo '</tr>';
        foreach ($routeCollection as $value) {
            if ($value->getPrefix() && explode('/', $value->getPrefix())[0] == 'api') {
                echo '<tr>';
                echo '<td>' . $value->methods()[0] . '</td>';
                echo '<td>' . $value->uri() . '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    }

    public function categoryId()
    {
    	$categories = ProductCategory::orderBy('sort')->get(['id', 'name'])->toArray();
    	//商品類別的id名稱對照表
    	echo "<table style='margin:0 auto; text-align:center; font-size:larger;' border='1'>";
        echo '<tr>';
        echo "<th>categoryId</th>";
        echo "<th>中文名稱</th>";
        echo '</tr>';
        foreach ($categories as $value) {  
            echo '<tr>';
            echo '<td>' . $value['id'] . '</td>';
            echo '<td>' . $value['name'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo "<h3 style='text-align:center;'>用於api/productItem?categoryId=?</h3>";
    }
}

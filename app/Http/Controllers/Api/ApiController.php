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
    	$user = $request->user();
    	$exipire_at = new DateTime();
        $exipire_at->add(new DateInterval('PT1H'));
        $accessToken = $user->createToken('api-token', ['bearer-token'], $exipire_at)->plainTextToken;

        $query = PersonalAccessToken::where('tokenable_type', 'App\Models\User')->where('tokenable_id', $user->id);
        $query->whereNotIn('id', (clone $query)->orderByDesc('created_at')->take(5)->pluck('id'))->delete();
        try{
    	Mail::to($user->email)->send(new TokenMail($accessToken));
    	}catch(\Exception $e){
    		dd($e->getMessage());
    	}

    	return response()->json(['status'=>true,'message'=>'token信件已成功寄出！']);
    }

    public function route()
    {
        $routeCollection = Route::getRoutes();

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

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsProductManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	//dd(auth()->user()->is_product_manager);
        if (!auth()->user()->is_product_manager) {
            return redirect()->route('dashboard')->with(['message' => '您不是 product manager，無權進入 productManage 頁面管理商品！']);
            //只能存進session flash，不會自動存進pages.props.flash.
        }
        return $next($request);
    }
}

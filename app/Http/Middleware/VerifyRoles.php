<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class VerifyRoles extends Middleware
{
    public $routes;

    public function __construct()
    {
        $this->routes = array(
            1 => ['publicidad'],
            2 => ['supply', 'category_supply'],
            3 => ['order'],
            4 => ['delivery'],
            5 => ['worker'],
            6 => ['asist'],
            7 => ['product', 'category_product'],
            8 => ['roles'],
            9 => ['coupon'],
            10 => ['map']
        );
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $id_role = $request->user()->id_role;

        $ruta = strtok($request->path(), '/');
        $permits = DB::Table('role_permit')
            ->where('role_permit.id_role', '=', $id_role)
            ->join('permits', 'permits.id', '=', 'role_permit.id_permit')
            ->select('role_permit.id_permit')
            ->get();
        foreach ($permits as $permit) {
            if (in_array($ruta, $this->routes[(int)$permit->id_permit])) {
                return $next($request);
            }
        }

        return redirect(RouteServiceProvider::HOME);
    }
}

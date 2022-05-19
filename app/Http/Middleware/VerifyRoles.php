<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\permit;
class VerifyRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(!Auth::check()){
            return redirect(RouteServiceProvider::HOME);
        }   
        $id_role =$request->user()->id_role;
        $ruta = $request->path();
        $permits = DB::Table('role_permit')
            ->where('role_permit.id_role','=',$id_role)
            ->join('permits','permits.id','=','role_permit.id_permit')
            ->select('permits.tipe_permit')
            ->get();
        foreach($permits as $permit){
            if($permit->tipe_permit == $ruta){
                return $next($request);
            }  
        }
        return redirect(RouteServiceProvider::HOME);
    }
}
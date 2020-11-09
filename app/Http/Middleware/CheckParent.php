<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
class CheckParent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if(auth()->user()->roles->where('name','parent')->first()!=null){
//           $kid_count = DB::table('parent_student')->where('user_id', auth()->user()->id)->count();
//           if($kid_count<1){
//               return redirect(route('parent.register'));
//           }
//        }        
        return $next($request);
    }
}

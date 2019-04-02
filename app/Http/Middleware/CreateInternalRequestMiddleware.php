<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateInternalRequestMiddleware
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
        $user_id = $request->user()->id;
        $checker = \DB::table('lock_configurations')->select('user_id')
                ->where('facility_name', '=', 'create_internal_request')
                ->where('user_id','=', $user_id)
                ->get();
        $counter = count($checker);
        if($counter == 1){
            return abort(451);
        }
        return $next($request);
    }
}

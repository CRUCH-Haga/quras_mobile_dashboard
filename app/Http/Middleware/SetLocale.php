<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 10/19/2018
 * Time: 2:23 AM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // Make sure current locale exists.
        if (Session::has('lang')) :
            $locale = Session::get('lang');
        else :
            $locale = config('app.fallback_locale');
        endif;
        App::setLocale($locale);

        return $next($request);
    }
}
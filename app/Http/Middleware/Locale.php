<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('locale.status')) {
            if (Session::has('locale') && array_key_exists(Session::get('locale'), config('locale.languages'))) {
                App::setLocalization(Session::get('locale'));
            }
        } else {
            $userLanguages = preg_split('/[,;]/', $request->server('HTTP_ACCEPT_LANGUAGE'));
            foreach ($userLanguages as $language)
            {
                if (array_key_exists($language, config('locale.languages')))
                {
                    App::setLocale($language);

                    setlocale(LC_TIME, config('locale.languages')[$language][2]);

                    Carbon::setLocale(config('locale.languages')[$language][0]);

                    if (config('locale.languages')[$language][2]) {
                        \session(['lang-rtl' => true]);
                    } else {
                        Session::forget('lang-rtl');
                    }

                    break;
                }
            }
        }
        return $next($request);
    }
}

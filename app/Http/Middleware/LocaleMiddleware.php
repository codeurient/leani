<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;


class LocaleMiddleware
{
    /*
     * Проверяет наличие корректной метки языка в текущем URL
     * Возвращает метку или значеие null, если нет метки
     */
    public function handle(Request $request, Closure $next)
    {
        $request->route()->forgetParameter('lang');

        $locale = self::getLocale();
        if ($locale) {
            App::setLocale($locale);
        } //если метки нет - устанавливаем основной язык $mainLanguage
        else {
            $segments = $request->segments();
            $segments[1] = config('app.fallback_locale');

            return redirect()->to(implode('/', $segments));
        }

        return $next($request); //пропускаем дальше - передаем в следующий посредник
    }

    /*
    * Устанавливает язык приложения в зависимости от метки языка из URL
    */

    public static function getLocale(): ?string
    {
        $locale = request()->segment(2);

        //Проверяем метку языка - есть ли она среди доступных языков
        if (!empty($locale) && in_array($locale, config('app.locales'))) {
            return $locale;
        }

        return null;
    }

}

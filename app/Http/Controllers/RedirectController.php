<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Visit;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * Обработчик для перехода пользователя по ссылке
     * @param Request $request
     * @param $code
     * @return mixed
     */
    public function redirect(Request $request, $code)
    {
        $link = Link::query()->active()->where('code', $code)->firstOrFail();

        // Добавляем открытие ссылки в статистику
        $visit = Visit::make([
            'ip' => $request->ip(),
            'useragent' => $request->userAgent()
        ]);

        $link->visits()->save($visit);

        return redirect($link->original_href, 301);
    }
}

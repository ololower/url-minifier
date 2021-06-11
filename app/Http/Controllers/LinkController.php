<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function create(Request $request)
    {
        $validationRules = [
            'link' => 'required|active_url',
            'expired_in_seconds' => 'required|integer|min:' . Link::MIN_EXPIRED_IN
        ];

        $validationErrors = [
            'link.required' => 'Вы не ввели ссылку',
            'link.active_url' => 'Ссылка, которую Вы ввели - не действительна',
            'expired_in_seconds.*' => 'Минимальное время жизни ссылки - 2 минуты'
        ];

        $request->validate($validationRules, $validationErrors);

        // Если введена ссылка минификатора - просто отображаем статистику по ней
        $linkUrl = Str::of($request->input('link'));
        if ($linkUrl->startsWith(env('APP_URL'))) {
            $code = $linkUrl->replace(env('APP_URL') . '/', '');
            if (strlen($code) == Link::LINK_LENGTH) {
                $returnUrl = route('statistics', [
                    'code' => $code
                ]);
            }
        }

        // Иначе - минифмцируем урл и редеректим на статистику
        if (!isset($returnUrl)) {
            $expiredSeconds = $request->input('expired_in_seconds', Link::MIN_EXPIRED_IN);

            $link = Link::create([
                'code' => Link::getUniqueLinkCode(),
                'original_href' => $request->input('link'),
                'expired_at' => Carbon::now()->addSeconds($expiredSeconds)
            ]);

            $returnUrl = route('statistics', [
                'code' => $link->code
            ]);
        }

        return redirect($returnUrl, 301);
    }
}

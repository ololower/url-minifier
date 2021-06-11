<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        $allowedExpires = [
            120 => '2 минуты',
            7200 => '2 дня',
            50400 => '2 недели'
        ];

        return view('welcome')->with([
            'allowed_expires' => $allowedExpires
        ]);
    }

    public function linkStatistics($code)
    {
        $link = Link::query()->where('code', $code)->firstOrFail();

        $data = [];

        $hoursLeft = Carbon::now()->diffInHours($link->expired_at);
        // Для вычисления остатка в минутах - добавим оставшиеся часы к текущему времени
        $minutesLeft = Carbon::now()->addHours($hoursLeft)->diffInMinutes($link->expired_at);
        $data['text_link_expired'] = sprintf("%s часа(ов) и %s минут(ы)", $hoursLeft, $minutesLeft);

        $data['is_link_active'] = $link->isActive();
        $data['original_href'] = $link->original_href;
        $data['href'] = route('link', $link->code);
        $data['visits_count'] = $link->visits()->count();

        $data['table_rows'] = [];
        foreach ($link->visits as $visit) {
            $data['table_rows'][] = [
                'ip' => $visit->ip,
                'useragent' => nl2br($visit->useragent),
                'created_at' => $visit->created_at->format('d.m.Y H:m')
            ];
        }

        return view('statistics')->with($data);
    }
}

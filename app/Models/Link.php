<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Link extends Model
{
    public const LINK_LENGTH = 6;
    public const MIN_EXPIRED_IN = 120;

    use HasFactory;

    protected $fillable = [
        'code',
        'original_href',
        'expired_at'
    ];

    public $timestamps = null;

    /**
     * True, если ссылка еще активна
     * @return bool
     */
    public function isActive()
    {
        return Carbon::now()->lessThan($this->expired_at);
    }

    public function scopeActive($query)
    {
        return $query->where('expired_at', '>', Carbon::now());
    }

    /**
     * Возвращает уникальный код ссылки
     * @return string
     */
    public static function getUniqueLinkCode()
    {
        $code = Str::random(Link::LINK_LENGTH);

        if (Link::query()->where('code', $code)->exists()) {
            $code = Link::getUniqueLinkCode();
        }

        return $code;
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'ip',
        'useragent'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

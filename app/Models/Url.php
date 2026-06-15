<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'url_name',
        'short_url_name',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

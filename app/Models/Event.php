<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;          //  ←  adaugă această linie

    protected $fillable = [
        'title', 'description',
        'start_at', 'end_at',
        'location', 'user_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'description',
        'start_at', 'end_at', 
        'location', 'user_id',
    ];
    
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    // ← ADAUGĂ ASTA:
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope pentru evenimente viitoare
    public function scopeUpcoming($query)
    {
        return $query->where('start_at', '>=', now());
    }
}
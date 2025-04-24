<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'status',
        'category',
        'priority',
        'user_id',
    ];

    //relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('start', Carbon::now()->month)
            ->whereYear('start', Carbon::now()->year);
    }
}

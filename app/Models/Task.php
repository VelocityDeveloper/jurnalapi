<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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
}

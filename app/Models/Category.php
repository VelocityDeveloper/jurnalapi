<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        // Gunakan event 'creating' atau 'saving' untuk mengisi 'code' sebelum disimpan
        static::creating(function ($category) {
            $category->code = Str::slug($category->name);
        });

        // Jika Anda ingin memastikan 'code' selalu diupdate saat 'name' diubah
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->code = Str::slug($category->name);
            }
        });
    }
}

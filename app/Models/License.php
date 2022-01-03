<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;
use Illuminate\Support\Str;

class License extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AsSource;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->key = auth()->user()->company_id;
        });
    }

    public static function key()
    {
        $r = Str::random(18);

        if (self::whereKey($r)->exists()) {
            return self::key();
        }

        return $r;
    }
}

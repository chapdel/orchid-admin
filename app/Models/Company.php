<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;
    use AsSource;

    protected $guarded = ['id'];

   /*  public function users()
    {
        return $this->hasMany(Profile::class, 'company_id');
    } */

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->code = self::code();
        });
    }

    public static function code()
    {
        $r = Str::random(7);

        if (self::whereKey($r)->exists()) {
            return self::key();
        }

        return $r;
    }

    public function license()
    {
        return $this->hasOne(License::class);
    }
}

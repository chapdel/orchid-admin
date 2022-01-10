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
    protected $hidden = ['id'];
    protected $appends = ['is_active'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->key = self::key();
        });
    }

    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class);
    }

    public function getPriceAttribute()
    {

        return (float) Str::replace(' ', '', Str::replace('FCFA', '', $this->licenseType->price));
    }

    public static function key()
    {
        $r = Str::random(18);

        if (self::whereKey($r)->exists()) {
            return self::key();
        }

        return $r;
    }

    public function getIsActiveAttribute()
    {
        return !$this->expired_at || $this->expired_at > now();
    }

    public function company()
    {
        return $this->hasOne(CompanyLicense::class);
    }
}

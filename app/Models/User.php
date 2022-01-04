<?php

namespace App\Models;

use Orchid\Platform\Models\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    public function scopeWeekSales()
    {
        $amount = 0;
        License::whereNotIn('status', ['pending', 'expired', 'canceled'])->whereDate('created_at', '>=', now()->subWeek())->each(function ($license) use (&$amount) {
            $amount += (float) Str::replace(' ', '', Str::replace('FCFA', '', $license->price));
        });

        return $amount;
    }

    public function scopeTotalSales()
    {
        $amount = 0;
        License::whereNotIn('status', ['pending', 'expired', 'canceled'])->each(function ($license) use (&$amount) {
            $amount += (float) Str::replace(' ', '', Str::replace('FCFA', '', $license->price));
        });

        return $amount;
    }
}

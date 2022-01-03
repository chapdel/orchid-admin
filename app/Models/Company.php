<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Company extends Model
{
    use HasFactory;
    use AsSource;

    protected $connection = 'mysql2';

    public function users()
    {
        return $this->hasMany(Profile::class, 'company_id');
    }
}

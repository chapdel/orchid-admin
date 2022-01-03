<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Profile extends Model
{
    use HasFactory;
    use AsSource;

    protected $connection = 'mysql2';

    protected $table = 'users';
}

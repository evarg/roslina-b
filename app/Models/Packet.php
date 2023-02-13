<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'name_polish',
        'name_latin',
        'producer',
        'expiration_date',
        'purchase_date',
    ];
}

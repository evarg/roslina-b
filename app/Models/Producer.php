<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'country',
    ];

    public function packets()
    {
        return $this->hasMany(Packet::class);
    }
}

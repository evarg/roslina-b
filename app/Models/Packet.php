<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Packet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'name_polish',
        'name_latin',
        'producer_id',
        'expiration_date',
        'purchase_date',
    ];

    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

    public function front()
    {
        return $this->belongsTo(File::class);
    }

    public function back()
    {
        return $this->belongsTo(File::class);
    }


}

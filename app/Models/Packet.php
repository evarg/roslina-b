<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *   @OA\Property(
 *    property="id",
 *    description="packet id",
 *    type="integer", readOnly="true",
 *  ),
 *  @OA\Property(
 *    property="name",
 *    description="packet name",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="desc",
 *    description="packet description",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="name_polish",
 *    description="polish package name",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="name_latin",
 *    description="latin package name",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="producer_id",
 *    description="package manufacturer id",
 *    type="integer",
 *  ),
 *   @OA\Property(
 *     property="expiration_date",
 *     description="package expiration date",
 *     type="string", format="date-time",
 *   ),
 *   @OA\Property(
 *     property="purchase_date",
 *     description="package purchase date",
 *     type="string", format="date-time",
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     description="Initial creation timestamp",
 *     type="string", format="date-time", readOnly="true",
 *   ),
 *   @OA\Property(property="updated_at",
 *     description="Last update timestamp",
 *     type="string", format="date-time", readOnly="true",
 *   ),
 * )
 */
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

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByProducer($query, int $producerID)
    {
        return $query->where('producer_id', $producerID)->get();
    }
}

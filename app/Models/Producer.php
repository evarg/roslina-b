<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   @OA\Property(
 *    property="id",
 *    description="packet id",
 *    type="integer", readOnly="true",
 *  ),
 *  @OA\Property(
 *    property="name",
 *    description="pproducer name",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="desc",
 *    description="producer description",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="country",
 *    description="country of manufacture",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="created_at",
 *    description="Initial creation timestamp",
 *    type="string", format="date-time", readOnly="true",
 *  ),
 *  @OA\Property(
 *    property="updated_at",
 *    description="Last update timestamp",
 *    type="string", format="date-time", readOnly="true",
 *  ),
 * )
 */
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

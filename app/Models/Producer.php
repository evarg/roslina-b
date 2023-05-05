<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * )
 */
class Producer extends Model
{
    use HasFactory;

    /**
     * The product name
     * @var string
     *
     * @OA\Property(
     *   type="string",
     *   description="The producer name"
     * )
     */
    public $name;

    /**
     * The product desc
     * @var string
     *
     * @OA\Property(
     *   type="string",
     *   description="The producer description"
     * )
     */
    public $desc;

    /**
     * The product name
     * @var string
     *
     * @OA\Property(
     *   type="string",
     *   description="The producer name"
     * )
     */
    public $country;

    /**
     * Packets list of producer
     * @var string
     *
     * @OA\Property(
     *   type="array",
     *   @OA\Items(
     *     ref="#/components/schemas/Packet"
     *   ),
     *   description="Packets list of producer"
     * )
     */
    public $packets;

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   @OA\Property(
 *     property="id",
 *     description="file id",
 *     type="integer",
 *   ),
 *   @OA\Property(
 *     property="name",
 *     description="file description",
 *     type="string",
 *   ),
 *   @OA\Property(
 *     property="org_name",
 *     type="string",
 *     description="file orginalfile name",
 *   ),
 *   @OA\Property(
 *     property="file_name",
 *     description="file file name",
 *     type="string",
 *   ),
 *   @OA\Property(
 *     property="mime",
 *     description="file mime type",
 *     type="string",
 *   ),
 *   @OA\Property(
 *     property="size",
 *     description="file size",
 *     type="string",
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
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc'
    ];

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf(
            '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }

    public function packets()
    {
        return $this->belongsToMany(Packet::class);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;

/**
 * @OA\Schema(
 *   @OA\Property(
 *    property="id",
 *    description="user's id",
 *    type="integer", readOnly="true",
 *  ),
 *  @OA\Property(
 *    property="name",
 *    description="user's name",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="email",
 *    description="user's email",
 *    type="string",
 *  ),
 *  @OA\Property(
 *    property="email_verified_at",
 *    description="date of email verification by the user",
 *    type="string", format="date-time", readOnly="true",
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     description="Initial creation timestamp",
 *     type="string", format="date-time", readOnly="true",
 *   ),
 *   @OA\Property(
 *     property="updated_at",
 *     description="Last update timestamp",
 *     type="string", format="date-time", readOnly="true",
 *   ),
 * )
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function packets()
    {
        return $this->hasMany(Packet::class, 'owner_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}

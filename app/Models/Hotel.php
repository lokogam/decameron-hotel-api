<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Hotel",
 *     required={"name", "address", "city", "nit", "total_rooms"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="city", type="string"),
 *     @OA\Property(property="nit", type="string"),
 *     @OA\Property(property="total_rooms", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="rooms",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Room")
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="HotelRequest",
 *     required={"name", "address", "city", "nit", "total_rooms"},
 *     @OA\Property(property="name", type="string", example="Hotel Paradise"),
 *     @OA\Property(property="address", type="string", example="123 Beach Road"),
 *     @OA\Property(property="city", type="string", example="Miami"),
 *     @OA\Property(property="nit", type="string", example="1234567890"),
 *     @OA\Property(property="total_rooms", type="integer", example=50)
 * )
 */



class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'address', 'city', 'nit', 'total_rooms'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

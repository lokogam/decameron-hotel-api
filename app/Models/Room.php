<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Room",
 *     required={"hotel_id", "room_type", "accommodation", "quantity"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="hotel_id", type="integer"),
 *     @OA\Property(
 *         property="room_type", 
 *         type="string",
 *         enum={"ESTANDAR", "JUNIOR", "SUITE"}
 *     ),
 *     @OA\Property(
 *         property="accommodation", 
 *         type="string",
 *         enum={"SENCILLA", "DOBLE", "TRIPLE", "CUADRUPLE"}
 *     ),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="hotel",
 *         ref="#/components/schemas/Hotel"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="RoomRequest",
 *     required={"hotel_id", "room_type", "accommodation", "quantity"},
 *     @OA\Property(property="hotel_id", type="integer", example=1),
 *     @OA\Property(
 *         property="room_type", 
 *         type="string", 
 *         enum={"ESTANDAR", "JUNIOR", "SUITE"},
 *         example="ESTANDAR"
 *     ),
 *     @OA\Property(
 *         property="accommodation", 
 *         type="string", 
 *         enum={"SENCILLA", "DOBLE", "TRIPLE", "CUADRUPLE"},
 *         example="SENCILLA"
 *     ),
 *     @OA\Property(property="quantity", type="integer", example=5)
 * )
 */


 

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'room_type', 'accommodation', 'quantity'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

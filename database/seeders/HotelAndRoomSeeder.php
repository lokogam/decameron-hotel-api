<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Room;

class HotelAndRoomSeeder extends Seeder
{
    public function run()
    {
        // Create DECAMERON CARTAGENA hotel
        $hotel = Hotel::factory()->create([
            'name' => 'DECAMERON CARTAGENA',
            'address' => 'CALLE 23 58-25',
            'city' => 'CARTAGENA',
            'nit' => '12345678-9',
            'total_rooms' => 42,
        ]);

        // Create rooms for DECAMERON CARTAGENA
        Room::factory()->create([
            'hotel_id' => $hotel->id,
            'room_type' => 'ESTANDAR',
            'accommodation' => 'SENCILLA',
            'quantity' => 25,
        ]);

        Room::factory()->create([
            'hotel_id' => $hotel->id,
            'room_type' => 'JUNIOR',
            'accommodation' => 'TRIPLE',
            'quantity' => 12,
        ]);

        Room::factory()->create([
            'hotel_id' => $hotel->id,
            'room_type' => 'ESTANDAR',
            'accommodation' => 'DOBLE',
            'quantity' => 5,
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        $roomType = $this->faker->randomElement(['ESTANDAR', 'JUNIOR', 'SUITE']);

        return [
            'hotel_id' => Hotel::factory(),
            'room_type' => $roomType,
            'accommodation' => $this->getValidAccommodation($roomType),
            'quantity' => $this->faker->numberBetween(1, 30),
        ];
    }

    private function getValidAccommodation($roomType)
    {
        switch ($roomType) {
            case 'ESTANDAR':
                return $this->faker->randomElement(['SENCILLA', 'DOBLE']);
            case 'JUNIOR':
                return $this->faker->randomElement(['TRIPLE', 'CUADRUPLE']);
            case 'SUITE':
                return $this->faker->randomElement(['SENCILLA', 'DOBLE', 'TRIPLE']);
            default:
                return null;
        }
    }
}
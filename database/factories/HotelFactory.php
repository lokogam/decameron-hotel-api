<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'nit' => $this->faker->unique()->numerify('#########-#'),
            'total_rooms' => $this->faker->numberBetween(10, 100),
        ];
    }
}

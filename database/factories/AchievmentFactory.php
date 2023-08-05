<?php

namespace Database\Factories;

use App\Models\Achievment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Achievment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'point' => $this->faker->randomNumber(0),
        ];
    }
}

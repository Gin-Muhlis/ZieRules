<?php

namespace Database\Factories;

use App\Models\Violation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViolationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Violation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(255),
            'point' => $this->faker->randomNumber(0),
        ];
    }
}

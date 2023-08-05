<?php

namespace Database\Factories;

use App\Models\Homeroom;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Homeroom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => \App\Models\Teacher::factory(),
            'class_id' => \App\Models\ClassStudent::factory(),
        ];
    }
}

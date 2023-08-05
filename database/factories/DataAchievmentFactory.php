<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DataAchievment;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataAchievmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataAchievment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(15),
            'achievment_id' => \App\Models\Achievment::factory(),
            'student_id' => \App\Models\Student::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
        ];
    }
}

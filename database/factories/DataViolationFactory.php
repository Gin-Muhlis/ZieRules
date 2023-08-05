<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DataViolation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataViolationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataViolation::class;

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
            'student_id' => \App\Models\Student::factory(),
            'violation_id' => \App\Models\Violation::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
        ];
    }
}

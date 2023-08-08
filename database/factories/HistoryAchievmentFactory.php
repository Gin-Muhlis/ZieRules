<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\HistoryAchievment;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryAchievmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HistoryAchievment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'student_id' => \App\Models\Student::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
            'achievment_id' => \App\Models\Achievment::factory(),
        ];
    }
}

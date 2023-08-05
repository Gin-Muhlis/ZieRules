<?php

namespace Database\Factories;

use App\Models\HistoryScan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryScanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HistoryScan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => \App\Models\Teacher::factory(),
            'student_id' => \App\Models\Student::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\HistoryTask;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HistoryTask::class;

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
            'task_id' => \App\Models\Task::factory(),
        ];
    }
}

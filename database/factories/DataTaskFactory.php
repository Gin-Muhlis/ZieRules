<?php

namespace Database\Factories;

use App\Models\DataTask;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataTask::class;

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
            'task_id' => \App\Models\Task::factory(),
            'student_id' => \App\Models\Student::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
        ];
    }
}

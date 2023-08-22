<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique->text(9),
            'name' => $this->faker->text(255),
            'password' => $this->faker->password(),
            'password_show' => $this->faker->password(),
            'gender' => 'laki-laki',
            'code' => $this->faker->text(11),
            'class_id' => \App\Models\ClassStudent::factory(),
        ];
    }
}

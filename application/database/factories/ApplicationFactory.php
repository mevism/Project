<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Approval\Entities\Application;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(1,100000),
            'receipt' => $this->faker->text,
            'user_id' => $this->faker->randomDigit,
            'telephone' => $this->faker->title,
            'status' => $this->faker->numberBetween(-1,6),
            'intake_name' => $this->faker->title,
            'attendance' => $this->faker->randomDigit,
             'year' => $this->faker->randomDigit,
            'academic_program' => $this->faker->title,
             'course' => $this->faker->title,
              'created_at' => $this->faker->timestamp,
               'updated_at' => $this->faker->timestamp
        ];
    }
}

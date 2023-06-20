<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    const GENDER_MALE   = 'male';
    const GENDER_FEMALE = 'female';

    const GENDER = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(self::GENDER);

        return [
            'first_name' => $this->faker->firstName($gender),
            'last_name'  => $this->faker->lastName($gender)
        ];
    }
}

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

    const MOBILE_CODES = [
        '039',
        '050',
        '063',
        '066',
        '067',
        '068',
        '073',
        '091',
        '092',
        '093',
        '094',
        '095',
        '096',
        '097',
        '098',
        '099'
    ];

    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(self::GENDER);

        return [
            'phone'      => '+38' . $this->faker->unique()->numerify(
                    $this->faker->randomElement(self::MOBILE_CODES) . '#######'
                ),
            'first_name' => $this->faker->firstName($gender),
            'last_name'  => $this->faker->lastName($gender)
        ];
    }
}

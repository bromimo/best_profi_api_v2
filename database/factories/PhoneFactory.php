<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
{
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
        return [
            'subject_id' => Subject::inRandomOrder()->first(),
            'phone' => '+38' . $this->faker->unique()->numerify(
                    $this->faker->randomElement(self::MOBILE_CODES) . '#######'
                ),
        ];
    }
}

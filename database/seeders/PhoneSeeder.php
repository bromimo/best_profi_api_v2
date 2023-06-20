<?php

namespace Database\Seeders;

use App\Models\Phone;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Phone::factory(200)->create();
    }
}

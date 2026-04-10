<?php

namespace Database\Seeders;

use Faker\ORM\CakePHP\Populator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Student;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $this->populateDB();
    }

    private function populateDB(): void
    {
        Student::factory()->count(10)->create();
    }
}

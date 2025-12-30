<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    public function run(): void
    {
        JobType::create(['name' => 'Bertegangan']);
        JobType::create(['name' => 'Tidak Bertegangan']);
    }
}

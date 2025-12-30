<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        JobType::create(['nama_pekerjaan' => 'Bertegangan']);
        JobType::create(['nama_pekerjaan' => 'Tidak Bertegangan']);
    }
}

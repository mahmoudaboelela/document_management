<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            [
                'name' => 'General',
                'enabled' => true,
            ],
            [
                'name' => 'Motors',
                'enabled' => true,
            ],
            [
                'name' => 'Jobs',
                'enabled' => true,
            ],
        );
        Module::insert($data);
    }
}

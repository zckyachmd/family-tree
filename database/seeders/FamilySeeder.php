<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Family $family): void
    {
        // Data to be seeded
        $data = [
            [
                'name'      => 'Budi',
                'gender'    => 'male',
                'parent_id' => null,
            ],
            [
                'name'      => 'Dedi',
                'gender'    => 'male',
                'parent_id' => 1
            ],
            [
                'name'      => 'Dodi',
                'gender'    => 'male',
                'parent_id' => 1
            ],
            [
                'name'      => 'Dede',
                'gender'    => 'male',
                'parent_id' => 1
            ],
            [
                'name'      => 'Dewi',
                'gender'    => 'female',
                'parent_id' => 1
            ],
            [
                'name'      => 'Feri',
                'gender'    => 'male',
                'parent_id' => 2
            ],
            [
                'name'      => 'Farah',
                'gender'    => 'female',
                'parent_id' => 2
            ],
            [
                'name'      => 'Gugus',
                'gender'    => 'male',
                'parent_id' => 3
            ],
            [
                'name'      => 'Gandi',
                'gender'    => 'male',
                'parent_id' => 3
            ],
            [
                'name'      => 'Hana',
                'gender'    => 'female',
                'parent_id' => 4
            ],
            [
                'name'      => 'Hani',
                'gender'    => 'female',
                'parent_id' => 4
            ]
        ];

        // Seed data
        foreach ($data as $key => $value) {
            $family->firstOrCreate($value);
        }
    }
}

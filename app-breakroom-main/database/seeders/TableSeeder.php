<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            [
                'number' => 1,
                'capacity' => 4,
                'price' => 40000
            ],
            [
                'number' => 2,
                'capacity' => 4,
                'price' => 40000
            ],
            [
                'number' => 3,
                'capacity' => 2,
                'price' => 55000
            ],
            [
                'number' => 4,
                'capacity' => 2,
                'status' => 'Closed',
                'price' => 55000
            ],
            [
                'number' => 5,
                'capacity' => 8,
                'price' => 125000
            ],
            [
                'number' => 6,
                'capacity' => 8,
                'status' => 'Closed',
                'price' => 125000
            ]
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}

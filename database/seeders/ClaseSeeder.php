<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clases')->insert([
            ['id' => 1, 'nombre' => 'Intensivo B1', 'nivel' => 'b1', 'codigo' => '1', 'profesor_id' => null],
            ['id' => 2, 'nombre' => 'Intensivo B2', 'nivel' => 'b2', 'codigo' => '2', 'profesor_id' => null],
            ['id' => 3, 'nombre' => 'Intensivo C1', 'nivel' => 'c1', 'codigo' => '3', 'profesor_id' => null],
        ]);
    }
}

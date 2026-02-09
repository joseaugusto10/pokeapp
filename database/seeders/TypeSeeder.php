<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        //eu peguei direto lá no site do pokeapi https://pokeapi.co/api/v2/type?offset=1&limit=100
        $types = [
            ['api_id' => 1, 'name' => 'normal'],
            ['api_id' => 2, 'name' => 'fighting'],
            ['api_id' => 3, 'name' => 'flying'],
            ['api_id' => 4, 'name' => 'poison'],
            ['api_id' => 5, 'name' => 'ground'],
            ['api_id' => 6, 'name' => 'rock'],
            ['api_id' => 7, 'name' => 'bug'],
            ['api_id' => 8, 'name' => 'ghost'],
            ['api_id' => 9, 'name' => 'steel'],
            ['api_id' => 10, 'name' => 'fire'],
            ['api_id' => 11, 'name' => 'water'],
            ['api_id' => 12, 'name' => 'grass'],
            ['api_id' => 13, 'name' => 'electric'],
            ['api_id' => 14, 'name' => 'psychic'],
            ['api_id' => 15, 'name' => 'ice'],
            ['api_id' => 16, 'name' => 'dragon'],
            ['api_id' => 17, 'name' => 'dark'],
            ['api_id' => 18, 'name' => 'fairy'],
            ['api_id' => 19, 'name' => 'stellar'],
            ['api_id' => 10001, 'name' => 'unknown'],
            ['api_id' => 10002, 'name' => 'shadow'],
        ];

        $rows = array_map(function ($t) use ($now) {
            return [
                'api_id' => $t['api_id'],
                'name' => $t['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $types);

        DB::table('types')->upsert(
            $rows,
            ['api_id'],
            ['name', 'updated_at']
        );
    }
}

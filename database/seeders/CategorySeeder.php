<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param =  [
        [
            'price' => '500',
        ],
        [
            'price' => '1,000',
        ],
        [
            'price' => '2,000',
        ]
        ];
        // DB::table('categories')->insert($param);
        // if (!DB::table('categories')->first()){
        // DB::table('categories')->insert([
        // ['price' => '500'],
        // ['price' => '1,000'],
        // ['price' => '2,000'],
        // ]);
    }
}

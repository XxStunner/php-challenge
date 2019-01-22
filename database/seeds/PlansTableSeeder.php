<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                "name" => "Plano easy",
                "price" => 25
            ],
            [
                "name" => "Plano normal",
                "price" => 40
            ],
            [
                "name" => "Plano hard",
                "price" => 60
            ]
        ];

        DB::table('plans')->insert($plans);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            [
                'id' => 1,
                'gender-name' => 'male'
            ],
            [
                'id' => 2,
                'gender-name' => 'female'
            ]
        ];

        DB::table('genders')->insert($genders);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
            'first_name' => 'Hoda',
            'last_name'  => 'Habibi',
            'full_name'  => 'Hoda Habibi',
        ]);

        DB::table('providers')->insert([
            'first_name' => 'Alex',
            'last_name'  => 'Brossard',
            'full_name'  => 'Alex Brossard',
        ]);

        DB::table('availabilities')->insert([
            'provider_id'     => 1,
            'start_datetime'  => '2019-05-08 12:00:00',
            'end_datetime'    => '2019-05-08 12:15:00',
        ]);

        DB::table('appointments')->insert([
            'start_datetime' => '2019-05-08 12:00:00',
            'end_datetime'   => '2019-05-08 12:15:00',
            'patient_id'     => 1,
            'provider_id'    => 1,
        ]);
    }
}

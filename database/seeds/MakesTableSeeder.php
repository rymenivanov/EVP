<?php

use DB;
use App\Make;
use App\Manufacturer;
use Illuminate\Database\Seeder;

class MakesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $make = Make::create(['title' => 'i3', 'speed' => 150, 'acceleration' => 8, 'capacity' => 4, 'charging_time' => '4h with the 240 V charging unit or less than 30 minutes at public DC charging stations (when charging from 0 to 80%)', 'range' => 183]);

        DB::table('makes')->insert([
        	['title' => 'i3', 'speed' => 150, 'acceleration' => 8, 'capacity' => 4, 'range' => 183, 'charging_time' => '4h with the 240 V charging unit or less than 30 minutes at public DC charging stations (when charging from 0 to 80%)', 'manufacturer_id' => 1],
        	['title' => 'Zinoro 1E', 'speed' => 130, 'acceleration' => 7.6, 'capacity' => 4, 'range' => 150, 'charging_time' => '', 'manufacturer_id' => 2],
        	['title' => 'Bluecar', 'speed' => 130, 'acceleration' => 0, 'capacity' => 4, 'range' => 250, 'charging_time' => '', 'manufacturer_id' => 3],
        	['title' => 'е6', 'speed' => 130, 'acceleration' => 8, 'capacity' => 5, 'range' => 300, 'charging_time' => '2h (VTOG 30 kW AC charging) 8—9h (SAE Level 2 AC charging)', 'manufacturer_id' => 4],
        	['title' => 'QQ3 EV', 'speed' => 150, 'acceleration' => 0, 'capacity' => 4, 'range' => 100, 'charging_time' => '', 'manufacturer_id' => 5],
        	['title' => 'Bolt EV', 'speed' => 0, 'acceleration' => 6.5, 'capacity' => 5, 'range' => 383, 'charging_time' => '', 'manufacturer_id' => 6],
        	['title' => 'Spark EV', 'speed' => 0, 'acceleration' => 0, 'capacity' => 4, 'range' => 132, 'charging_time' => '', 'manufacturer_id' => 6],
        	['title' => 'C-Zero', 'speed' => 130, 'acceleration' => 15.9, 'capacity' => 4, 'range' => 150, 'charging_time' => '7 hours when charged from household; 30 minutes when charging from a quick charger system', 'manufacturer_id' => 7],
        	['title' => 'C-ZEN', 'speed' => 110, 'acceleration' => 0, 'capacity' => 2, 'range' => 130, 'charging_time' => '5-7 hours', 'manufacturer_id' => 8],
        	['title' => 'Solo', 'speed' => 132, 'acceleration' => 8, 'capacity' => 1, 'range' => 161, 'charging_time' => '3-6 hours', 'manufacturer_id' => 9],
        	['title' => '500e', 'speed' => 142, 'acceleration' => 8.5, 'capacity' => 4, 'range' => 140, 'charging_time' => '', 'manufacturer_id' => 10],
        	['title' => 'Focus Electric', 'speed' => 135, 'acceleration' => 9.9, 'capacity' => 5, 'range' => 185, 'charging_time' => '', 'manufacturer_id' => 11],
        	['title' => 'Azkarra', 'speed' => 0, 'acceleration' => 0, 'capacity' => 2, 'range' => 150, 'charging_time' => '', 'manufacturer_id' => 12],
        	['title' => 'Fit EV', 'speed' => 148, 'acceleration' => 9.5, 'capacity' => 2, 'range' => 132, 'charging_time' => '', 'manufacturer_id' => 13],
        	['title' => 'Ioniq', 'speed' => 185, 'acceleration' => 10.8, 'capacity' => 4, 'range' => 190, 'charging_time' => '4 hours', 'manufacturer_id' => 14],
        	['title' => 'Kona Electric', 'speed' => 0, 'acceleration' => 10.8, 'capacity' => 4, 'range' => 470
        	, 'charging_time' => '4 hours', 'manufacturer_id' => 14],
        ]);
    }
}

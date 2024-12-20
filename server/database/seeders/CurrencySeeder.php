<?php

namespace Database\Seeders;

use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $client = new Client();

        $response = $client->get('https://restcountries.com/v3.1/all');

        $countries = json_decode($response->getBody());

        $countryData = [];
        foreach($countries as $country){
            $countryData[] = [
                'name' => $country['name']['official'],
                'cca2' => $country['cca2'],
                'cca3' => $country['cca3'],
                'rate' => 0.00, // suffixes values is an array
                'currency' => "Naira",
                'currency_code' => $country['currencies'][0],
                'currency_name' => $country['currencies'][0]['name'],
                'currency_symbol' => $country['currencies'][0]['symbol'],
                'status' => 0,

            ];
        }
                DB::table('currencies')->insert($countryData);

 
    }
}

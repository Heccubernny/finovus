<?php
namespace Database\Seeders;

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountriesTableSeeder extends Seeder{
    public function run():void {
        // $client = new Client();

        // $response = $client->get('https://restcountries.com/v3.1/all');

        // $countries = json_decode($response->getBody());
        $json = File::get(database_path('seeders/countries.json'));
        $countries = json_decode($json, true);

        // $countries = json_encode($countries);

        $countryData = [];
        
        foreach($countries as $country){
            $phoneCode = isset($country['idd']['root']) ? $country['idd']['root'] . (isset($country['idd']['suffixes'][0]) ? $country['idd']['suffixes'][0] : '') : null;
$currencyCode = null;
            $currencyName = null;
            $currencySymbol = null;
            if (isset($country['currencies']) && is_array($country['currencies'])) {
                foreach ($country['currencies'] as $code => $currency) {
                    $currencyCode = $code;
                    $currencyName = $currency['name'] ?? null;
                    $currencySymbol = $currency['symbol'] ?? null;
                    break; // Assuming only one currency per country
                }
            }

             $maleDemonyms = null;
            $femaleDemonyms = null;
            if (isset($country['demonyms']['eng'])) {
                $maleDemonyms = $country['demonyms']['eng']['m'] ?? null;
                $femaleDemonyms = $country['demonyms']['eng']['f'] ?? null;
            }

            $gini = null;
            if (isset($country['gini']) && is_array($country['gini'])) {
                foreach ($country['gini'] as $year => $value) {
                    $gini = $value;
                    break; // Get the first gini value
                }
            }

            $tld = null;
            if (isset($country['tld']) && is_array($country['tld'])) {
                foreach ($country['tld'] as $value) {
                    $tld = $value;
                    break; // Get the first gini value
                }
            }

            $capital = null;
            if (isset($country['capitabl']) && is_array($country['capitabl'])) {
                foreach ($country['capitabl'] as $value) {
                    $capital = $value;
                    break; // Get the first gini value
                }
            }

            $continent = null;
            if (isset($country['continents']) && is_array($country['continents'])) {
                foreach ($country['continents'] as $value) {
                    $continent = $value;
                    break; // Get the first gini value
                }
            }
            $timezones = null;
            if (isset($country['timezones']) && is_array($country['timezones'])) {
                foreach ($country['timezones'] as $value) {
                    $tld = $value;
                    break; // Get the first gini value
                }
            }
 
            // echo $phoneCode;
            $countryData[] = [
                'name' => $country['name']['official'] ?? null,
                'common_name' => $country['name']['common'] ?? null,
                'cca2' => $country['cca2'],
                'cca3' => $country['cca3'] ?? null,
                'cc_num_code' => $country['ccn3'] ?? null,
                'phone_code' => $phoneCode,
                'currency_code' => $currencyCode,
                'currency_name' => $currencyName,
                'currency_symbol' => $currencySymbol,
                'flag' => $country['flag'] ?? null,
                'continents' => $continent,
                'capital' => $capital,
                'region' => $country['region'] ?? null,
                'subregion' => $country['subregion'] ?? null,
                'demonyms_female' => $maleDemonyms,
                'demonyms_male' => $femaleDemonyms,
                'google_maps' => $country['maps']['googleMaps'] ?? null,
                'open_street_maps' => $country['maps']['openStreetMaps'] ?? null,
                'population' => $country['population'] ?? null,
                'fifa' => $country['fifa'] ?? null,
                'gini' => $gini,
                'area' => $country['area'] ?? null,
                'tld' => $tld,
                'un_member' => $country['unMember'] ?? false,
                'independent' => $country['independent'] ?? false,
                'borders' => $country['borders'] ?? null,
                'timezones' => $timezones,
            ];
        }
        DB::table('countries')->insert($countryData);
    }
}
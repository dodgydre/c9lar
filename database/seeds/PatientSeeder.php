<?php

use Illuminate\Database\Seeder;
use App\Patient;
use App\Insurer;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->command->info('Start PatientSeeder');


        $patient = new Patient;
        $patient->chart_number = 'GEOAN000';
        $patient->first_name = 'Andreas';
        $patient->last_name = 'Georghiou';
        $patient->insurer1 = 'BLU000';
        $patient->save();

        $patient1 = new Patient;
        $patient1->chart_number = 'GRAJA000';
        $patient1->first_name = 'Janice';
        $patient1->last_name = 'Grace';
        $patient1->insurer1 = 'GRE000';
        $patient1->save();

        $faker = Faker\Factory::create();
        $limit = 33;

        $insurers = Insurer::get();

        for($i = 0; $i < $limit; $i++) {
          $first = $faker->firstName;
          $last = $faker->lastName;

          $newChartStart = strtoupper(substr($last, 0, 3) . substr($first, 0, 2));
          $charts = Patient::where('chart_number', 'LIKE', $newChartStart . '%')->get();
          $endNumber = (string)count($charts);  // include 000 as a chart number

          $newChart = $newChartStart . str_pad($endNumber, 3, "0", STR_PAD_LEFT);

          $insurer1 = $insurers->random();

          DB::table('patients')->insert([
            'first_name' => $first,
            'last_name' => $last,
            'chart_number' => $newChart,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'postcode' => $faker->postcode,
            'province' => $faker->state,
            'country' => $faker->country,
            'phone1' => $faker->phoneNumber,
            'phone2' => $faker->phoneNumber,
            'phone3' => $faker->phoneNumber,
            'email' => $faker->email,
            'insurer1' => $insurer1->code
          ]);
        }
        $this->command->info('End PatientSeeder');


    }
}

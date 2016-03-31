<?php

use Illuminate\Database\Seeder;
use App\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patient = new Patient;
        $patient->chart_number = 'GEOAN000';
        $patient->first_name = 'Andreas';
        $patient->last_name = 'Georghiou';
        $patient->save();

        $patient1 = new Patient;
        $patient1->chart_number = 'GRAJA000';
        $patient1->first_name = 'Janice';
        $patient1->last_name = 'Grace';
        $patient1->save();
    }
}
    
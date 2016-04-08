<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Transaction;
use App\Patient;
use App\Procedure;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->command->info('Start TransactionSeeder');

      $procedureCodes = Procedure::where('type','=','A')->orWhere('type','=','B')->where('type', '!=', 'H')->pluck('code');
      $procedures = Procedure::where('type','=','A')->orWhere('type','=','B')->where('type', '!=', 'H')->get();
      $patients = Patient::get()->pluck('chart_number', 'id');

      $faker = Faker\Factory::create();
      $limit = 750;

      for($i = 0; $i < $limit; $i++) {
        $patient_id = rand(1, $patients->count()-1);
        $chart_number = $patients[$patient_id];
        $unit = rand(1,3);
        $randomProcedure = $procedures->random();
        $amount = $randomProcedure->amount;
        $total = $unit * $amount;

        $date = $faker->dateTimeBetween($startDate = 'now-5 years', $endDate = 'now');

        DB::table('transactions')->insert([
          'date_from' => $date->format('Y-m-d'),
          'patient_id' => $patient_id,
          'chart_number' => $chart_number,
          'units' => $unit,
          'amount' => $amount,
          'units' => 1,
          'total' => $total,
          'procedure_code' => $randomProcedure->code,
          'procedure_description' => $randomProcedure->description,
          'transaction_type' => $randomProcedure->type,
          'unapplied_amount' => $total
        ]);
      }

      $this->command->info('End TransactionSeeder');

    }
}

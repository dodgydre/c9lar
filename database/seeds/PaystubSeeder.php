<?php

use Illuminate\Database\Seeder;
use App\Paystub;
use Carbon\Carbon;

class PaystubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->command->info('Start PaystubSeeder');

      $ppe = Carbon::create(2014,1,1);
      $gross = 2000;
      $cpp = 50;
      $emp_cpp = $cpp;
      $ei = 25;
      $emp_ei = 30;
      $fed_tax = 300;
      $prov_tax = 200;
      $net = $gross - ($cpp+$ei+$fed_tax+$prov_tax);

      for($i = 1; $i < 75; $i++)
      {
        DB::table('paystubs')->insert([
          'employee_id' => 1,
          'ppe' => $ppe->format('Y-m-d'),
          'gross' => $gross,
          'cpp' => $cpp,
          'emp_cpp' => $emp_cpp,
          'ei' => $ei,
          'emp_ei' => $emp_ei,
          'fed_tax' => $fed_tax,
          'prov_tax' => $prov_tax,
          'net' => $net
        ]);
        $ppe = $ppe->addWeeks(2);

      }
      $this->command->info('End PaystubSeeder');

    }
}

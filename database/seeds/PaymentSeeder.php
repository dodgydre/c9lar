<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Transaction;
use App\Patient;
use App\Procedure;

class PaymentSeeder extends Seeder
{
  public function run()
  {
    $this->command->info('Start PaymentSeeder');

    $procedures = Procedure::where('type', '!=', 'A')->where('type', '!=', 'B')->where('type', '!=', 'H')->where('type', '!=', 'I')->get();
    $insuranceProcedures = Procedure::where('type', '=', 'I')->get();

    $patients = Patient::get();

    $faker = Faker\Factory::create();
    $transactions = Transaction::get();

    foreach($transactions as $transaction)
    {
      // only do charges (ie total > 0)
      $total = $transaction->total;
      if($total > 0) {
        // only pay 80% of the transactions:
        if(rand(1,10) <= 8) {
          // pay in one or two payments (ie. just the patient (70%) or patient+insurance (30%))
          if(rand(1,10) <= 7) {
            // make a 100% patient transaction:
            $patient_id = $transaction->patient_id;
            $chart_number = $transaction->chart_number;
            $total = -$transaction->total;
            $random_procedure = $procedures->random();
            $procedure_code = $random_procedure->code;
            $procedure_description = $random_procedure->description;
            $procedure_type = $random_procedure->type;

            $id = DB::table('transactions')->insertGetId([
              'date_from' => $transaction->date_from,
              'patient_id' => $patient_id,
              'chart_number' => $chart_number,
              'total' => $total,
              'procedure_code' => $procedure_code,
              'procedure_description' => $procedure_description,
              'transaction_type' => $procedure_type,
              'who_paid' => 'G',
              'unapplied_amount' => 0
            ]);

            DB::table('payments')->insert([
              'payment_ref' => $id,
              'charge_ref' => $transaction->id,
              'amount' => $total,
              'who_paid' => 'G'
            ]);

            DB::table('transactions')->where('id', $transaction->id)->update(['unapplied_amount'=>0, 'g_amount_paid'=>$total]);
          }

          else {
            $patient_id = $transaction->patient_id;
            $chart_number = $transaction->chart_number;
            $total = -$transaction->total;
            $random_procedure = $procedures->random();
            $procedure_code = $random_procedure->code;
            $procedure_description = $random_procedure->description;
            $procedure_type = $random_procedure->type;

            $random_insurance_procedure = $insuranceProcedures->random();
            $insurance_procedure_code = $random_insurance_procedure->code;
            $insurance_procedure_description = $random_insurance_procedure->description;
            $insurance_procedure_type = $random_insurance_procedure->type;

            $id = DB::table('transactions')->insertGetId([
              'date_from' => $transaction->date_from,
              'patient_id' => $patient_id,
              'chart_number' => $chart_number,
              'total' => 0.3*$total,
              'procedure_code' => $procedure_code,
              'procedure_description' => $procedure_description,
              'transaction_type' => $procedure_type,
              'unapplied_amount' => 0,
              'who_paid' => 'G'
            ]);

            DB::table('payments')->insert([
              'payment_ref' => $id,
              'charge_ref' => $transaction->id,
              'amount' => 0.3*$total,
              'who_paid' => 'G'
            ]);

            $id = DB::table('transactions')->insertGetId([
              'date_from' => $transaction->date_from,
              'patient_id' => $patient_id,
              'chart_number' => $chart_number,
              'total' => 0.7*$total,
              'procedure_code' => $procedure_code,
              'procedure_description' => $procedure_description,
              'transaction_type' => $procedure_type,
              'unapplied_amount' => 0,
              'who_paid' => '1'
            ]);

            DB::table('payments')->insert([
              'payment_ref' => $id,
              'charge_ref' => $transaction->id,
              'amount' => 0.7*$total,
              'who_paid' => '1'
            ]);

            DB::table('transactions')
              ->where('id', $transaction->id)
              ->update(['unapplied_amount'=>0, 'g_amount_paid'=>0.3*$total, 'i1_amount_paid'=>0.7*$total]);


          }
        }
      }
    }
    $this->command->info('End PaymentSeeder');

  }
}

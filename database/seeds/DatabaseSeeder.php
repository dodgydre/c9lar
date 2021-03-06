<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(EntrustSeeder::class);
        $this->call(ProcedureSeeder::class);
        $this->call(InsurerSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(PaystubSeeder::class);
        $this->call(ProviderSeeder::class);
        $this->call(CalendarSeeder::class);
    }
}

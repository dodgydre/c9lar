<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Start EmployeeSeeder');

        $emp1 = new Employee;
        $emp1->first_name = 'Andreas';
        $emp1->last_name = 'Georghiou';
        $emp1->save();

        $this->command->info('End EmployeeSeeder');
        
    }
}

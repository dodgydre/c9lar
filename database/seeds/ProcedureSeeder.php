<?php

use Illuminate\Database\Seeder;
use App\Procedure;

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $procedure1 = new Procedure;
        $procedure1->code = 'CA';
        $procedure1->type = 'A';
        $procedure1->description = 'Chiropractic Adjustment';
        $procedure1->amount = 45;
        $procedure1->save();

        $procedure2 = new Procedure;
        $procedure2->code = 'RMT45';
        $procedure2->type = 'A';
        $procedure2->description = '45 Minute Massage';
        $procedure2->amount = 90;
        $procedure2->save();

    }
}
  
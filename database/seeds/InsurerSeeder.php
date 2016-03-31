<?php

use Illuminate\Database\Seeder;
use App\Insurer;

class InsurerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insurer1 = new Insurer;
        $insurer1->code = 'BLU001';
        $insurer1->name = 'Blue Cross Medavie';
        $insurer1->save();
    }
}
  
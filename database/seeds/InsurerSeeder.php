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
      $this->command->info('Start InsurerSeeder');

      $insurer1 = new Insurer;
      $insurer1->code = 'BLU000';
      $insurer1->name = 'Blue Cross Medavie';
      $insurer1->save();

      $insurer2 = new Insurer;
      $insurer2->code = 'GRE000';
      $insurer2->name = 'Green Shield';
      $insurer2->save();

      $this->command->info('End InsurerSeeder');

    }
}

<?php

use Illuminate\Database\Seeder;
use App\Provider;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->command->info('Start ProviderSeeder');

        $provider1 = new Provider;
        $provider1->type = "chiropractor";
        $provider1->first_name = "Janice";
        $provider1->last_name = "Grace";
        $provider1->code="JEG";
        $provider1->save();

        $provider2 = new Provider;
        $provider2->type = "massage";
        $provider2->first_name = "Catherine";
        $provider2->last_name = "Hounsell";
        $provider2->code="CH";
        $provider2->save();

        $this->command->info('End ProviderSeeder');
    }
}

<?php

use Illuminate\Database\Seeder;

class TurnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Turn::class, 10)->create();
    }
}

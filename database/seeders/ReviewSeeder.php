<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewSeeder extends Seeder
{
	use DatabaseTransactions;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Review::factory()->count(50)->create();
    }
}

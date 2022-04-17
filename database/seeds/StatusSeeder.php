<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'name' => '新規',
            ],
            [
                'name' => '進行中',
            ],
            [
                'name' => '完了',
            ],
            [
                'name' => '終了',
            ],
        ]);
    }
}

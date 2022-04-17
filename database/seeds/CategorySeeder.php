<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'ECサイト',
            ],
            [
                'name' => 'オンラインサロン',
            ],
            [
                'name' => 'SNSサイト',
            ],
            [
                'name' => '予約システム',
            ],
            [
                'name' => '社内管理システム',
            ],
        ]);
    }
}

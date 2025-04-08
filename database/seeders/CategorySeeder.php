<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert(
            [
                [
                    'title'=> 'рисунок',
                ],
                [
                    'title'=> 'акварель',
                ],
                [
                    'title'=> 'гуашь',
                ],
                [
                    'title'=> 'другое',
                ],
            ]
        );
    }
}

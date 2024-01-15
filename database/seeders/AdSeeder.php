<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Ad;



class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('ads')->insert([
            'title' => Str::random(10),
            'slug' => Str::random(10),
            'text' => Str::random(10),
            'phone' => int::random(10),
            
        ]);
    }
}

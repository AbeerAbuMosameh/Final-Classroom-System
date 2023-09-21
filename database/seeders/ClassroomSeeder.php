<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert( [
            'name' => 'Classroom 1',
            'code' => 'ABC123',
            'section' => 'Section A',
            'subject' => 'Math',
            'room' => 'Room 101',
            'cover_image' => 'img1.jpg',
            'theme' => 'Default',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

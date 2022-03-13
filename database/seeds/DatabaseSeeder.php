<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([[
            'name' => 'Fiction',
        ]]);

        DB::table('categories')->insert([[
            'name' => 'Science',
        ]]);

        DB::table('categories')->insert([[
            'name' => 'Computer',
        ]]);

        DB::table('categories')->insert([[
            'name' => 'School',
        ]]);
        
        DB::table('users')->insert([[
            'name' => 'Chaerul Rizky',
            'email' => 'chaerul.rizky@binus.ac.id',
            'password' => Hash::make('abcde'),
            // 'image' => '/profileImg/chaerul.rizky@binus.ac.id.jpg',
            // 'banned' => 'yes',
            'coin' => 100
        ]]);

        DB::table('users')->insert([[
            'name' => 'Chaerul',
            'email' => 'chaerul.rizkyy@binus.ac.id',
            'password' => Hash::make('abcde'),
            // 'image' => '/profileImg/chaerul.rizky@binus.ac.id.jpg',
            'coin' => 100
        ]]);

        factory(App\Chat::class, 50)->create();
        factory(App\Book::class, 100)->create();
    }
}

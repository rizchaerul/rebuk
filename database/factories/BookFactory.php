<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\User;
use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(Book::class, function (Faker $faker) {
    $userCount = count(User::all());
    $categoryCount = count(Category::all());

    $randNum = $faker->numberBetween(1, 10);
    $id = uniqid();
    Storage::copy('/bookSample/'.$randNum.'.jpg', '/bookImg/'.$id.'.jpg');
    // Storage::put($filename, file_get_contents($request->file('image')));
    
    return [
        'title' => $faker->name(),
        'category_id' => $faker->numberBetween(1, $categoryCount),
        'image' => '/bookImg/'.$id.'.jpg',
        // 'image' => 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/action-thriller-book-cover-design-template-3675ae3e3ac7ee095fc793ab61b812cc_screen.jpg?ts=1588152105',
        'user_id' => $faker->numberBetween(1, $userCount),
        'rating' => $faker->numberBetween(1, 5),
        'description' => $faker->paragraph(6)
    ];
});

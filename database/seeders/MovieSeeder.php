<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $movie =  Movie::factory(100)->create();
        $genres = Genre::pluck('id');
        $last = count($genres) - 1;

        for ($i = 0; $i < 100; $i++) {
            $movie = Movie::create([
                'title' => fake()->sentence(3),
                'description' => fake()->sentence(),
                'author' => fake()->name(),
                'duration' => fake()->numberBetween(60, 180),
                'poster_url' => fake()->imageUrl()
            ]);

            if (count($genres)) {
                $movie->genres()->attach($genres[rand(0, $last)]);
            }
        }
    }
}

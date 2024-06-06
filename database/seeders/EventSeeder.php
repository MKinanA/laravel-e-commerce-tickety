<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $eventCount = 24, int $ticketCount = 4): void
    {
        if (Category::count() == 0) {
            $this->call(CategorySeeder::class);
        };
        $faker = Factory::create();
        for ($x = 0; $x < $eventCount; $x ++) {
            $event = Event::create([
                'name' => $faker->sentence(2),
                'slug' => $faker->unique()->slug(2),
                'headline' => $faker->sentence(8),
                'description' => $faker->paragraph(4),
                'start_time' => $faker->dateTimeBetween('+4 years', '+24 years'),
                'location' => $faker->address(),
                'duration' => $faker->numberBetween(60, 86400),
                'is_popular' => $faker->randomElement([true, false]),
                'photos' => null,
                'type' => $faker->randomElement(['online', 'offline']),
                'category_id' => Category::inRandomOrder()->first()->id
            ]);
            for ($y = 0; $y < $ticketCount; $y ++) {
                $event->tickets()->create([
                    'name' => $faker->sentence(2),
                    'price' => $faker->numberBetween(5, 20),
                    'quantity' => $faker->numberBetween(10, 80),
                    'max_buy' => $faker->numberBetween(1, 3)
                ]);
            };
        };
    }
}

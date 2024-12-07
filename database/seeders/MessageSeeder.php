<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $startDate = now()->subYear();

        for ($user_id = 1; $user_id <= 2; $user_id++) {
            Message::factory()
                ->count(30)
                ->sequence(fn($sequence) => [
                    'user_id' => $user_id,
                    'room_id' => 1,
                    'body' => $faker->realText(rand(20, 100)),
                    'created_at' => $startDate->copy()->addHours($sequence->index)
                ])
                ->create();
        }
    }
}

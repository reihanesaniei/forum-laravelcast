<?php

namespace Database\Factories;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

class ThreadFactory extends Factory
{
    public function definition()
    {
        $title = fake()->text(50);
        return [
            'user_id' => User::factory(),
            'channel_id' => Channel::factory(),
            'title' => $title,
            'body' =>  fake()->text(500),
            'slug' => Str::slug($title)
        ];
    }
}

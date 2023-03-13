<?php

namespace Database\Factories;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;



class ReplyFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'thread_id' => Thread::factory(),
            'body' => fake()->text(),
            'best_flag'=>'0'
        ];
    }
}

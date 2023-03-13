<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ChannelFactory extends Factory
{
    public function definition()
    {
        $name = fake()->text(50);
        return [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
    }
}

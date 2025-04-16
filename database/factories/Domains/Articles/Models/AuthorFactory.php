<?php

namespace Database\Factories\Domains\Articles\Models;

use App\Domains\Articles\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }

    public function withUser(): AuthorFactory
    {
        return $this->for(User::factory(), 'user');
    }
}

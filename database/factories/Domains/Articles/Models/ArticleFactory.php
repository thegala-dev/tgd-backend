<?php

namespace Database\Factories\Domains\Articles\Models;

use App\Domains\Articles\Models\Article;
use App\Domains\Articles\Models\Author;
use App\Domains\Articles\Models\Tag;
use App\Domains\Website\Enums\Category;
use App\Domains\Website\Enums\Drawer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'markdown' => fake()->text(),
            'hero' => fake()->url(),
            'drawer' => fake()->randomElement(Drawer::cases()),
            'categories' => collect(fake()->randomElements(Category::cases(), 3)),
            'published_at' => now(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Article $article) {
            Tag::factory()
                ->count(rand(1, 3))
                ->create()
                ->each(fn (Tag $tag) => $article->tags()->attach($tag));
        });
    }

    public function withAuthor(): ArticleFactory
    {
        return $this->for(Author::factory()->withUser(), 'author');
    }

    public function withTags(): ArticleFactory
    {
        return $this->afterCreating(function (Article $article) {
            $article->tags()->attach(
                Tag::factory()->count(3)->create()
            );
        });
    }
}

<?php

namespace Tests\Unit\Models\Concerns;

use App\Domains\Articles\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class HasSlugTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_slug_from_name_when_creating_a_author(): void
    {
        $author = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $this->assertEquals('test-author', $author->slug);
    }

    /** @test */
    public function it_generates_a_unique_slug_if_the_name_already_exists(): void
    {
        Author::factory()->create([
            'name' => 'Test Author',
            'slug' => 'test-author',
        ]);

        $author2 = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $this->assertEquals('test-author-1', $author2->slug);
    }

    /** @test */
    public function it_considers_soft_deleted_authors_when_generating_a_slug(): void
    {
        $author = Author::factory()->create([
            'name' => 'Test Author',
            'slug' => 'test-author',
        ]);

        $author->delete();

        $author2 = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $this->assertEquals('test-author-1', $author2->slug);
    }

    /** @test */
    public function it_increments_slug_correctly_when_multiple_duplicates_exist(): void
    {
        Author::factory()->create(['name' => 'Test Author', 'slug' => 'test-author']);
        Author::factory()->create(['name' => 'Test Author', 'slug' => 'test-author-1']);
        Author::factory()->create(['name' => 'Test Author', 'slug' => 'test-author-2']);

        $author = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $this->assertEquals('test-author-3', $author->slug);
    }

    /** @test */
    public function it_handles_empty_name_by_generating_ulid_based_slug(): void
    {
        $author = new Author;
        $reflection = new \ReflectionMethod($author, 'getSlugSource');
        $reflection->setAccessible(true);

        $slugSource = $reflection->invoke($author);

        $this->assertTrue(Str::isUlid($slugSource), 'Slug source should be a ULID if name is missing');
    }

    /** @test */
    public function it_generates_a_new_unique_slug_when_recreating_a_soft_deleted_author_with_same_name(): void
    {
        $author = Author::factory()->create([
            'name' => 'Test Author',
        ]);
        $author->delete();

        $newAuthor = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $this->assertEquals('test-author-1', $newAuthor->slug);
    }
}

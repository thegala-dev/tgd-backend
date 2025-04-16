<?php

namespace Tests\Unit\Domains\Utils\ValueObjects;

use App\Domains\Utils\ValueObjects\Author;
use App\Domains\Utils\ValueObjects\FrontMatter;
use App\Domains\Utils\ValueObjects\Tag;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Enums\Category;
use App\Domains\Website\Enums\Drawer;
use Tests\TestCase;

class ValueObjectTest extends TestCase
{
    public function test_author_value_object(): void
    {
        $author = new Author('filippo.galante@thegala.dev', 'Filippo Galante');

        $this->assertEquals('Filippo Galante', $author->name);
        $this->assertEquals('filippo.galante@thegala.dev', $author->email);
    }

    public function test_tag_value_object(): void
    {
        $tag = new Tag('thegala.dev', 'the gala dev');

        $this->assertEquals('thegala.dev', $tag->slug);
        $this->assertEquals('the gala dev', $tag->label);
    }

    public function test_front_matter_value_object(): void
    {
        $frontMatter = new FrontMatter(
            slug: 'perche-questo-blog',
            title: 'Perché questo blog',
            description: 'Spoiler: non è solo un blog',
            hero: '/assets/img/hero.jpg',
            drawer: $drawer = fake()->randomElement(Drawer::cases()),
            categories: $categories = collect(fake()->randomElements(Category::cases(), 3)),
            tags: $tags = collect([new Tag('thegala.dev', 'the gala dev')]),
            author: $author = new Author('filippo.galante@thegala.dev', 'Filippo Galante'),
        );

        $this->assertEquals('perche-questo-blog', $frontMatter->slug);
        $this->assertEquals('Perché questo blog', $frontMatter->title);
        $this->assertEquals('Spoiler: non è solo un blog', $frontMatter->description);
        $this->assertEquals('/assets/img/hero.jpg', $frontMatter->hero);
        $this->assertEquals($drawer, $frontMatter->drawer);
        $this->assertEquals($categories, $frontMatter->categories);
        $this->assertEquals($tags, $frontMatter->tags);
        $this->assertEquals($author, $frontMatter->author);
    }

    public function test_website_content_value_object(): void
    {
        $frontMatter = new FrontMatter(
            slug: 'perche-questo-blog',
            title: 'Perché questo blog',
            description: 'Spoiler: non è solo un blog',
            hero: '/assets/img/hero.jpg',
            drawer: fake()->randomElement(Drawer::cases()),
            categories: collect(fake()->randomElements(Category::cases(), 3)),
            tags: collect([new Tag('thegala.dev', 'the gala dev')]),
            author: new Author('filippo.galante@thegala.dev', 'Filippo Galante'),
        );
        $markdown = '# Titolo\nContenuto';

        $content = new WebsiteContent(
            frontMatter: $frontMatter,
            markdown: $markdown
        );

        $this->assertEquals($frontMatter, $content->frontMatter);
        $this->assertEquals($markdown, $content->markdown);
    }
}

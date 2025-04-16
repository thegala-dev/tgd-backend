<?php

use App\Domains\Website\Enums\Drawer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('author_id')->constrained('authors');

            $table->string('title');
            $table->string('slug');
            $table->string('description');
            $table->longText('markdown');
            $table->string('hero')->nullable(); // TODO: deve diventare una relazione
            $table->enum('drawer', Drawer::toArray(true));
            $table->json('categories')->nullable();
            $table->date('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('article_tag', function (Blueprint $table) {
            $table->foreignUlid('article_id')->constrained('articles');
            $table->foreignUlid('tag_id')->constrained('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('articles');
    }
};

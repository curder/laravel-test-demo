<?php

namespace Tests\Unit\Integration\Models;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ArticleTest
 *
 * @package Tests\Unit\Integration\Models
 */
class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_trending_articles(): void
    {
        // Given
        Article::factory(2)->create();
        Article::factory()->create(['reads' => 10]);
        $mostPopular = Article::factory()->create(['reads' => 20]);

        // When
        $articles = Article::trending();

        // Then
        self::assertEquals($mostPopular->id, $articles->first()->id);
        self::assertCount(3, $articles);
    }
}

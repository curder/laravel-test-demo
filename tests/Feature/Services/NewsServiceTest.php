<?php

namespace Tests\Feature\Services;

use App\Exceptions\NewsRequestException;
use App\Services\NewsService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    /** @test */
    public function it_can_fetch_top_headlines_news(): void
    {
        Http::fake(function ($request) {
            return Http::response(
                json_decode(file_get_contents(__DIR__.'/stubs/headlines.json'), true)
            );
        });

        $response = NewsService::make()->headlines();

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-Api-Key') &&
                $request->url() === config('services.news.base_url') . '/v2/top-headlines?country=us';
        });

        $this->assertCount(20, $response['articles']);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('totalResults', $response);
        $this->assertArrayHasKey('articles', $response);
    }

    /** @test */
    public function throw_exception_when_request_failed(): void
    {
        Http::fake(function ($request) {
            return Http::response([], Response::HTTP_UNAUTHORIZED);
        });

        $this->expectException(NewsRequestException::class);

        NewsService::make()->headlines();
    }
}

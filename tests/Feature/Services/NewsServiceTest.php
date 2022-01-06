<?php

namespace Tests\Feature\Services;

use Illuminate\Http\Client\Request;
use Tests\TestCase;
use App\Services\NewsService;
use Illuminate\Support\Facades\Http;
use App\Exceptions\NewsRequestException;
use Symfony\Component\HttpFoundation\Response;

class NewsServiceTest extends TestCase
{
    /** @test */
    public function it_can_fetch_top_headlines_news(): void
    {
        Http::fake([
           config('services.news.base_url'). '/*' => Http::response(
               json_decode(file_get_contents(__DIR__.'/stubs/headlines.json'), true)
           ),
        ]);

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
        Http::fake([
            config('services.news.base_url'). '/*' => Http::response([], Response::HTTP_UNAUTHORIZED),
        ]);

        $this->expectException(NewsRequestException::class);

        NewsService::make()->headlines();
    }
}

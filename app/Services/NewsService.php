<?php

namespace App\Services;

use App\Exceptions\NewsRequestException;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Class NewsService
 *
 * @package \App\Services
 */
class NewsService
{
    public static function make(): self
    {
        return new static();
    }

    /**
     * @throws NewsRequestException
     * @throws Throwable
     */
    public function headlines()
    {
        $response = Http::baseUrl(config('services.news.base_url'))
            ->withHeaders([
                'X-Api-Key' => config('services.news.api_token'),
            ])
            ->get('/v2/top-headlines', [
                'country' => 'us',
            ]);

        throw_if(
            $response->failed() && $response->json('status') !== 'ok',
            new NewsRequestException()
        );

        return $response->json();
    }
}

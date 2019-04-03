<?php

namespace App\Services;

use GuzzleHttp\Psr7\Response;

/**
 * Class MockedJXApiClient
 *
 * @package \App\Services
 */
class MockedJXApiClient
{
    public function get($uri, array $options = [])
    {
        \Log::channel('game_api_request')->info("GET Request to JX API", [
            'uri'     => $uri,
            'options' => $options,
        ]);

        return new Response(200, [], "1: Success");
    }

    public function post($uri, array $options = [])
    {
        \Log::channel('game_api_request')->info("POST Request to JX API", [
            'uri'     => $uri,
            'options' => $options,
        ]);

        return new Response(200, [], "1: Success");
    }
}

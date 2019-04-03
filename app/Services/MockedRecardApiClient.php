<?php

namespace App\Services;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MockedRecardApiClient
 *
 * @package \App\Services
 */
class MockedRecardApiClient
{
    protected static $mockedResponse;

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     */
    public static function setMockedResponse(Response $response)
    {
        self::$mockedResponse = $response;
    }

    public function get($uri, array $options = [])
    {
        \Log::channel('recard_mock')->info("GET Request to Recard API", [
            'uri'     => $uri,
            'options' => $options,
        ]);

        return $this->response();
    }

    public function post($uri, array $options = [])
    {
        \Log::channel('recard_mock')->info("POST Request to Recard API", [
            'uri'     => $uri,
            'options' => $options,
        ]);

        return $this->response();
    }

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function response()
    {
        if (self::$mockedResponse instanceof ResponseInterface) {
            $response = self::$mockedResponse;
        } else {
            $response = new Response(200, [], json_encode(['transaction_code' => time(), 'success' => true]));
        }

        return $response;
    }
}

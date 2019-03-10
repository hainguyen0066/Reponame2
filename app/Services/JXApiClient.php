<?php

namespace App\Services;

use GuzzleHttp\Client;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class JXApiClient
 *
 * @package \App\Services
 */
class JXApiClient
{
    const ENDPOINT_CREATE_USER = '/api/register.php';
    const ENDPOINT_SET_PASSWORD = '/api/changepass1.php';
    const ENDPOINT_SET_SECONDARY_PASSWORD = '/api/changepass2.php';
    const ENDPOINT_ADD_GOLD    = '/api/donate.php';
    const ENDPOINT_CCU         = '/api/getccu.php';

    static $responseStack = [];
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct($baseUrl, $apiKey)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl
        ]);
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
    }

    /**
     * @param $response
     */
    protected function addResponseStack($response)
    {
        array_push(self::$responseStack, $response);
    }

    /**
     * @return mixed|null
     */
    public function getLastResponse()
    {
        return count(self::$responseStack) ? array_pull(self::$responseStack) : null;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function createUser($username, $password)
    {
        $signed = md5($this->apiKey . $username);
        $params = ['tk' => $username, 'mk' => $password, 'sign' => $signed];
        $response = $this->client->get(self::ENDPOINT_CREATE_USER, [
            'query' => $params
        ]);
        $body = $response->getBody()->getContents();
        $responseCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);
        if(substr($responseCode, 0, 2) != '1:') {
            return false;
        }

        return true;
    }

    /**
     * @param $username
     * @param $newPassword
     *
     * @return bool
     */
    public function setPassword($username, $newPassword)
    {
        $signed = md5($this->apiKey . $username);
        $params = ['tk' => $username, 'mk' => $newPassword, 'sign' => $signed];
        $response = $this->client->get(self::ENDPOINT_SET_PASSWORD, [
            'query' => $params
        ]);
        $body = $response->getBody()->getContents();
        $responseCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);
        if(substr($responseCode, 0, 2) != '1:') {
            return false;
        }

        return true;
    }

    /**
     * @param $username
     * @param $newSecondaryPassword
     *
     * @return bool
     */
    public function setSecondaryPassword($username, $newSecondaryPassword)
    {
        $signed = md5($this->apiKey . $username);
        $params = ['tk' => $username, 'mk' => $newSecondaryPassword, 'sign' => $signed];
        $response = $this->client->get(self::ENDPOINT_SET_SECONDARY_PASSWORD, [
            'query' => $params
        ]);
        $body = $response->getBody()->getContents();
        $responseCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);
        if(substr($responseCode, 0, 2) != '1:') {
            return false;
        }

        return true;
    }

    /**
     * @param     $username
     * @param int $gold
     *
     * @return bool
     */
    public function addGold($username, $gold)
    {
        $signed = md5($this->apiKey . $username);
        $params = ['tk' => $username, 'knb' => $gold, 'sign' => $signed];
        $response = $this->client->get(self::ENDPOINT_ADD_GOLD, [
            'query' => $params
        ]);
        $body = $response->getBody()->getContents();
        $responseCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);
        if(substr($responseCode, 0, 2) != '1:') {
            return false;
        }

        return true;
    }

    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCcu()
    {
        $response = $this->client->get(self::ENDPOINT_CCU);
        $body = $response->getBody()->getContents();

        return explode('-', $body);
    }
}

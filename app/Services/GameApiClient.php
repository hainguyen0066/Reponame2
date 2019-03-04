<?php
namespace App\Services;

use GuzzleHttp\Client;

class GameApiClient
{
    const METHOD_PLAY_GAME   = 'gameplay';
    const METHOD_USER_INFO   = 'roleinfo';
    const METHOD_ADD_GOLD    = 'recharge';
    const METHOD_ADD_ITEM    = 'sendmail';
    const METHOD_ONLINE_TIME = 'daytimeonline';
    const METHOD_CCU         = 'totaluseronline';

    const TYPE_WEB         = '0';
    const TYPE_MINI_CLIENT = '1';

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
    private $endpoint;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct($baseUrl, $endpoint, $apiKey)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl
        ]);
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
        $this->endpoint = "/" . ltrim($endpoint, '/');
    }

    /**
     * @param $userId
     * @param $username
     * @param $serverId
     *
     * @return string
     */
    public function getUrlPlayGame($userId, $username, $serverId)
    {
        $type = self::TYPE_WEB;
        $now = time() - (60*20);
        $signedHash = md5("{$userId}{$username}{$serverId}{$type}{$now}{$this->apiKey}");
        $queryString = http_build_query([
            'method'   => self::METHOD_PLAY_GAME,
            'serverid' => $serverId,
            'userid'   => $userId,
            'username' => $username,
            'type'     => $type,
            'timestamp'=> $now,
            'sign'     => $signedHash,
        ]);

        return $this->baseUrl . $this->endpoint . "?" . $queryString;
    }

    /**
     * @param     $orderId
     * @param     $username
     * @param     $serverId
     * @param int $money
     * @param int $gold
     *
     * @return bool
     */
    public function addGold($orderId, $username, $serverId, $money = 0, $gold = 0)
    {
        $now = time();
        $signedHash = md5("{$username}{$serverId}{$orderId}{$money}{$gold}{$now}{$this->apiKey}");
        $data = [
            'method'   => self::METHOD_ADD_GOLD,
            'serverid' => $serverId,
            'username' => $username,
            'money'    => $money,
            'gold'     => $gold,
            'time'     => $now,
            'sign'     => $signedHash,
            'orderid'  => $orderId,
        ];
        $queryString = http_build_query($data);
        $response = $this->client->post($this->endpoint . "?" . $queryString);
        $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (isset($data->errno) && $data->errno == 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $username
     * @param $serverId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUserInfo($username, $serverId)
    {
        $now = time();
        $signedHash = md5("{$username}{$serverId}{$now}{$this->apiKey}");
        $data = [
            'method'   => self::METHOD_USER_INFO,
            'serverid' => $serverId,
            'username' => $username,
            'time'     => $now,
            'sign'     => $signedHash,
        ];
        $queryString = http_build_query($data);
        $response = $this->client->post($this->endpoint . "?" . $queryString);

        return $response;
    }

    /**
     * @param        $username
     * @param        $serverId
     * @param        $itemId
     * @param int    $quantity
     * @param string $subject
     * @param string $content
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addItem($username, $serverId, $itemId, $quantity = 1, $subject = "System", $content = "Quà từ hệ thống")
    {
        $now = time();
        $signedHash = md5("{$username}{$serverId}{$itemId}{$quantity}{$now}{$this->apiKey}");
        $data = [
            'method'   => self::METHOD_ADD_ITEM,
            'serverid' => $serverId,
            'username' => $username,
            'item_id'  => $itemId,
            'item_num' => $quantity,
            'subject'  => $subject,
            'content'  => $content,
            'time'     => $now,
            'sign'     => $signedHash,
        ];
        $queryString = http_build_query($data);
        $response = $this->client->post($this->endpoint . "?" . $queryString);

        return $response;
    }

    /**
     * @param $username
     * @param $serverId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOnlineTime($username, $serverId)
    {
        $now = time();
        $signedHash = md5("{$username}{$serverId}{$now}{$this->apiKey}");
        $data = [
            'method'   => self::METHOD_ONLINE_TIME,
            'serverid' => $serverId,
            'username' => $username,
            'time'     => $now,
            'sign'     => $signedHash,
        ];
        $queryString = http_build_query($data);
        $response = $this->client->post($this->endpoint . "?" . $queryString);

        return $response;
    }

    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCcu()
    {
        $now = time();
        $signedHash = md5("{$now}{$this->apiKey}");
        $data = [
            'method'   => self::METHOD_CCU,
            'time'     => $now,
            'sign'     => $signedHash,
        ];
        $queryString = http_build_query($data);
        $response = $this->client->post($this->endpoint . "?" . $queryString);

        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }
}

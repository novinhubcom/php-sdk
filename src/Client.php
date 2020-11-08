<?php

/**
 * The PHP library for use with the Novinhub REST API.
 *
 * @license MIT
 */


namespace Novinhub;

use GuzzleHttp;


/**
 * Class Client
 */
class Client
{
    private $apiVersion = 'v1';
    private $apiHost = 'https://panel.novinhub.com/api';
    private $hasFile = false;

    /**
     * @var string token for api
     */
    private $token;
    private $guzzle_client;

    /**
     * API constructor.
     * @param null $token for user Auth
     * @param string $apiVersion
     */
    public function __construct($token = null, $apiVersion = 'v1')
    {
        if (!empty($token)) {
            $this->setToken($token);
        }
        $this->guzzle_client = new GuzzleHttp\Client([
            'http_errors' => false,
            'verify' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0'
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param $apiVersion
     */
    public function setVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param $filePath
     * @return bool|resource
     */
    public function getFile($filePath)
    {
        $this->hasFile = true;
        return fopen($filePath, 'r');
    }

    /**
     * Make GET requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function get($path, $parameters = [])
    {
        return $this->http('GET', $this->apiHost, $path, $parameters);
    }

    /**
     * @param string $method
     * @param string $host
     * @param string $path
     * @param array $parameters
     *
     * @return array|object|string
     */
    private function http($method, $host, $path, $parameters)
    {
        $url = sprintf('%s/%s/%s', $host, $this->apiVersion, $path);


        if ($this->hasFile) {
            $params = array();
            foreach ($parameters as $key => $value) {
                $params[] = array(
                    'name' => $key,
                    'contents' => $value
                );
            }
            $request_key = 'multipart';
            $request_value = $params;
        } else {
            $request_key = 'form_params';
            $request_value = $parameters;
        }

        try {
            $response = $this->getGuzzleClient()->request($method, $url . '?token=' . $this->token, [
                $request_key => $request_value
            ]);


            $data = $response->getBody()->getContents();
            $json = json_decode($data, true);
            return $json;
        } catch (\Exception $e) {
            return 'متاسفانه برای ارسال درخواست شما مشکلی به وجود آمد، لطفا دوباره تلاش کنید.';
        }
    }

    public function getGuzzleClient()
    {
        return $this->guzzle_client;
    }

    /**
     * Make POST requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function post($path, $parameters = [])
    {
        return $this->http('POST', $this->apiHost, $path, $parameters);
    }

    /**
     * Make DELETE requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function delete($path, $parameters = [])
    {
        return $this->http('DELETE', $this->apiHost, $path, $parameters);
    }

    /**
     * Make PUT requests to the API.
     *
     * @param string $path
     * @param array $parameters
     *
     * @return array|object
     */
    public function put($path, $parameters = [])
    {
        return $this->http('PUT', $this->apiHost, $path, $parameters);
    }
}







<?php

namespace shop\shipping\np\endPoints;

use shop\shipping\np\NpClient;

class NpAbstractApi
{
    /** @var NpClient */
    private $client;

    public function __construct(NpClient $client)
    {
        $this->client = $client;
    }

    protected function get(array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->get($parameters, $requestHeaders);
        return $response;
    }

    protected function post(array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->post($parameters, $requestHeaders);
        return $response;
    }

    protected function delete(array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->delete($parameters, $requestHeaders);
        return $response;
    }
}
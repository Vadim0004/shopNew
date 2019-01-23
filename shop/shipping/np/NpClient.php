<?php

namespace shop\shipping\np;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use shop\readModels\shop\ConfigurationReadRepository;
use shop\shipping\np\endPoints\address\NpAddressPoint;

class NpClient
{
    /**
     * HTTP status codes
     */
    const HTTP_NO_CONTENT = 204;

    /** @var Client */
    private $client;

    /** @var array */
    private $config = [
        'url' => 'https://api.novaposhta.ua',
        'json' => '/v2.0/json/',
        'xml' => '/v2.0/xml/',
    ];

    /** @var array */
    private $options;

    /** @var string */
    private $baseUrl;

    /** @var ConfigurationReadRepository */
    private $repository;

    /** @var string*/
    private $apiKey;

    public function __construct(Client $client, ConfigurationReadRepository $repository)
    {
        $this->repository = $repository;
        $this->apiKey = $this->repository->getConfigurationValue('MODULE_SHIPPING_NP_APIKEY')->configuration_value;
        $this->client = $client;
        $this->baseUrl = $this->config['url'] . $this->config['json'];
        $this->options = [
            'headers' => [
                'content-type' => 'application/json',
            ],
            'json' => [
                'apiKey' => $this->apiKey,
            ]
        ];

    }

    /**
     * @param ResponseInterface $response
     * @return mixed|null
     */
    private function parseResponseBody(ResponseInterface $response)
    {
        $body = (string)$response->getBody();
        if (empty($body)) {
            if ($response->getStatusCode() === self::HTTP_NO_CONTENT) {
                return null;
            }
            throw new \DomainException('No response body found.');
        }
        $object = @json_decode($body);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \DomainException("Unable to decode response: '{$body}'.");
        }
        return $object;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function get(array $options = [], array $headers = [])
    {
        $response = $this->client->get($this->baseUrl, array_merge($options, $this->arrayMergeMy($this->options, $options), $headers));
        return $this->parseResponseBody($response);
    }

    public function post(array $options = [], array $headers = [])
    {
        $response = $this->client->post($this->baseUrl, array_merge($this->options, $this->arrayMergeMy($this->options, $options), $headers));
        return $this->parseResponseBody($response);
    }

    public function delete(array $options = [], array $headers = [])
    {
        $response = $this->client->delete($this->baseUrl, array_merge($this->options, $this->arrayMergeMy($this->options, $options), $headers));
        return $this->parseResponseBody($response);
    }

    public function api($name)
    {
        switch ($name) {
            case 'address':
                $api = new NpAddressPoint($this);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
        return $api;
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param array $parameters Request parameters
     *
     * @return null|string
     */
    protected function createJsonBody(array $parameters)
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }

    /**
     * @param array $array1
     * @param array $array2
     * @return array
     */
    protected function arrayMergeMy(array $array1, array $array2): array
    {
        $res['json'] = $array1['json'] + $array2['json'];
        return $res;
    }
}
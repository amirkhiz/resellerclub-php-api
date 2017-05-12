<?php

namespace afbora\ResellerClub;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

trait Helper
{
    /**
     * @var Guzzle
     */
    protected $guzzle;

    /**
     * Authentication info needed for every request
     * @var array
     */
    private $authentication = [];

    /**
     * @var string
     */
    protected $api;

    public function __construct(Guzzle $guzzle, array $authentication)
    {
        $this->authentication = $authentication;
        $this->guzzle         = $guzzle;
    }

    protected function get($method, $args = [], $prefix = '')
    {
        return $this->parse(
            $this->guzzle->get(
                $this->api . '/' . $prefix . $method . '.json?' . preg_replace(
                    '/%5B[0-9]+%5D/simU',
                    '',
                    http_build_query(array_merge($args, $this->authentication))
                )
            )
        );
    }

    protected function getXML($method, $args = [], $prefix = '')
    {
        return $this->parse(
            $this->guzzle->get(
                $this->api . '/' . $prefix . $method . '.xml?' . preg_replace(
                    '/%5B[0-9]+%5D/simU',
                    '',
                    http_build_query(array_merge($args, $this->authentication))
                )
            ),
            'xml'
        );
    }

    protected function post($method, $args = [], $prefix = '')
    {
        return $this->parse(
            $this->guzzle->request(
                'POST',
                $this->api . '/' . $prefix . $method . '.json',
                [
                    RequestOptions::FORM_PARAMS => $args,
                ]
            )
        );
    }

    /**
     * @param ResponseInterface $response
     * @param string $type
     * @return mixed|\SimpleXMLElement
     * @throws \Exception
     */
    protected function parse(ResponseInterface $response, $type = 'json')
    {
        switch ($type) {
            case 'json':
                return json_decode((string)$response->getBody(), TRUE);
            case 'xml':
                return simplexml_load_file((string)$response->getBody());
            default:
                throw new \Exception(
                    "Invalid response
                 type"
                );
        }
    }

    protected function processAttributes($attributes = [])
    {
        $data = [];

        $i = 0;
        foreach ($attributes as $key => $value) {
            $i++;
            $data["attr-name{$i}"]  = $key;
            $data["attr-value{$i}"] = $value;
        }

        return $data;
    }
}
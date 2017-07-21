<?php

namespace habil\ResellerClub;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
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

    public function __construct(Guzzle $guzzle, array $authentication)
    {
        $this->authentication = $authentication;
        $this->guzzle         = $guzzle;
    }

    protected function get($method, $args = [], $prefix = '')
    {
        try {
            return $this->parse(
                $this->guzzle->get(
                    $this->api . '/' . $prefix . $method . '.json?' . preg_replace(
                        '/%5B[0-9]+%5D/simU',
                        '',
                        http_build_query(array_merge($args, $this->authentication))
                    )
                )
            );
        } catch (ClientException $e) {
            return $this->parse($e->getResponse());
        } catch (ServerException $e) {
            return $this->parse($e->getResponse());
        } catch (BadResponseException $e) {
            return $this->parse($e->getResponse());
        } catch (\Exception $error) {
            return $error;
        }
    }

    protected function getXML($method, $args = [], $prefix = '')
    {
        try {
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
        } catch (ClientException $e) {
            return $this->parse($e->getResponse(), 'xml');
        } catch (ServerException $e) {
            return $this->parse($e->getResponse(), 'xml');
        } catch (BadResponseException $e) {
            return $this->parse($e->getResponse(), 'xml');
        } catch (\Exception $error) {
            return $error;
        }
    }

    protected function post($method, $args = [], $prefix = '')
    {
        //Todo use middleware to merge default values in guzzle
        //Merge default args with sent one
        $args = array_merge($args, $this->authentication);

        try {
            return $this->parse(
                $this->guzzle->request(
                    'POST',
                    $this->api . '/' . $prefix . $method . '.json',
                    [
                        RequestOptions::FORM_PARAMS => $args,
                    ]
                )
            );
        } catch (ClientException $e) {
            return $this->parse($e->getResponse());
        } catch (ServerException $e) {
            return $this->parse($e->getResponse());
        } catch (BadResponseException $e) {
            return $this->parse($e->getResponse());
        } catch (\Exception $error) {
            return $error;
        }
    }

    public function postArgString($method, $args = '', $prefix = '')
    {
        $authenticationString = http_build_query($this->authentication);

        try {
            return $this->parse(
                $this->guzzle->request(
                    'POST',
                    $this->api . '/' . $prefix . $method . '.json?' . preg_replace(
                        '/%5B[0-9]+%5D/simU',
                        '',
                        $args . '&' . $authenticationString
                    )
                )
            );
        } catch (ClientException $e) {
            return $this->parse($e->getResponse());
        } catch (ServerException $e) {
            return $this->parse($e->getResponse());
        } catch (BadResponseException $e) {
            return $this->parse($e->getResponse());
        } catch (\Exception $error) {
            return $error;
        }
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
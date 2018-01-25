<?php
namespace Melas\Sharenet;

use GuzzleHttp\Client;

class Sharenet
{
    private $baseUrl = 'http://app.sharenet.io/api/';

    private $key;

    private $requestOptions;

    private $response;

    private $client;

    public function __construct()
    {
        $this->setKey();
        $this->setRequestOptions();
    }

    private function setKey()
    {
        $this->key = config('sharenet.secret');
    }

    private function setRequestOptions()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer '. $this->key,
                //'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ]
        ]);
    }
    
    public function send(array $data) 
    {
        $path = 'send';
        $this->response = $this->client->post($this->baseUrl . $path, ["form_params" => $data]);
        return $this;
    }

    public function getResponse()
    {
        return $this->response ? json_decode($this->response->getBody()) : null;
    }

    public function isSuccessful()
    {
        return $this->getResponse() ? $this->getResponse()->status === 'success' : false;
    }
}
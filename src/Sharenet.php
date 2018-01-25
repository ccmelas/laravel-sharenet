<?php
/*
 * This file is part of the Laravel Sharenet package.
 * (c) Chiemela Chinedum <chiemelachinedum@gmail.com>
 */

namespace Melas\Sharenet;

use GuzzleHttp\Client;

class Sharenet
{
    /**
     * Sharenet API Base URL
     * @var string
     */
    private $baseUrl = 'http://app.sharenet.io/api/';

    /**
     * Sharenet USER secret
     * Available in the developer tab of the user profile page
     * @var string
     */
    private $key;

    /**
     * API Response
     */
    private $response;

    /**
     * GuzzleHttp Client
     */
    private $client;

    public function __construct()
    {
        $this->setKey();
        $this->setRequestOptions();
    }

    /**
     * Sets the API Secret Key
     * @param null
     * @return void
     */
    private function setKey()
    {
        $this->key = config('sharenet.secret');
    }

    /**
     * Prepares the request options
     * @param void
     * @return void
     */
    private function setRequestOptions()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer '. $this->key,
                'Accept'        => 'application/json'
            ]
        ]);
    }
    
    /**
     * Sends the sms payload to the gateway
     * @param array
     * @return Sharenet::class
     */
    public function send(array $data) 
    {
        $path = 'send';
        $this->response = $this->client->post($this->baseUrl . $path, ["form_params" => $data]);
        return $this;
    }

    /**
     * Getter for the $response variable
     * Returns null if there's no response
     */
    public function getResponse()
    {
        return $this->response ? json_decode($this->response->getBody()) : null;
    }

    /**
     * Confirms if SMS was sent successfully
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getResponse() ? $this->getResponse()->status === 'success' : false;
    }
}
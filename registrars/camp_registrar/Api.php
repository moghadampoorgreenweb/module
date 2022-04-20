<?php

class Api
{

    private \GuzzleHttp\Client $api;

    public function __construct($baseurl, $token)
    {
        $this->baseurl = $baseurl;
        $this->token = $token;
    }

    public function request($methode, $endpoint, $data, $dataMethode = null)
    {
        $this->api = new \GuzzleHttp\Client([
            'base_uri' => $this->baseurl,
        ]);
        try {
            $client = $this->api->request($methode, $endpoint, [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'X-Foo' => ['Bar', 'Baz'],
                    'Authorization' => "Bearer {$this->token}",
                ],
                $dataMethode => $data
            ]);
            return $client->getBody()->getContents();
        } catch (Exception $e) {
            file_put_contents(__DIR__ . '/file.josn', json_encode($e->getMessage()));
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function post($endpoint, $param)
    {
        return $this->request('post', $endpoint, $param, 'form_params');
    }

    public function delete($endpoint, $param)
    {
        return $this->request('delete', $endpoint, $param, 'form_params');
    }

    public function put($endpoint, $param)
    {
        return $this->request('put', $endpoint, $param, 'json');
    }

    public function get($endpoint, $param = null, $dataMethode = null)
    {
        return $this->request('get', $endpoint, $param, $dataMethode);
    }

}
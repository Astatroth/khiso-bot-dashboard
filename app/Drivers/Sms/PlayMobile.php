<?php

namespace App\Drivers\Sms;

use App\Interfaces\Drivers\SmsDriverInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

class PlayMobile implements SmsDriverInterface
{
    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $login
     * @param string $password
     * @param string $endpoint
     */
    public function __construct(string $login, string $password, string $endpoint)
    {
        $this->apiUrl = $endpoint;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @param string $phone
     * @param string $content
     * @return string
     */
    protected function makeRequest(string $phone, string $content): string
    {
        $request = [
            'messages'=>[
                'recipient' => $phone,
                'message-id' => 'dst'.uniqid(),
                'sms' => [
                    'originator' => 'KHISO',
                    'content' =>[
                        'text' => $content
                    ]
                ]
            ]
        ];

        return json_encode($request);
    }

    /**
     * @param string $recipient
     * @param string $message
     * @return bool
     */
    public function sendMessage(string $phoneNumber, string $message): void
    {
        $request = $this->makeRequest($phoneNumber, $message);

        $this->sendRequest($request);
    }

    /**
     * @param string $request
     * @return bool
     */
    protected function sendRequest(string $request): bool
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode($this->login.':'.$this->password)
        ];
        $body = $request;
        $request = new Request('POST', $this->apiUrl, $headers, $body);

        try {
            $response = $client->sendAsync($request)->wait();
        } catch (ClientException $e) {
            \Log::error($e->getMessage());

            return false;
        }

        return true;
    }
}

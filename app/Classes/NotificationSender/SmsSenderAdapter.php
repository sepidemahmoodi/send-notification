<?php
namespace App\Classes\NotificationSender;


use GuzzleHttp\Client;

class SmsSenderAdapter implements SenderInterface
{
    private $baseUrl;
    private $response;
    private $code;
    private $client;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client();
    }

    public function send(array $data): bool
    {
        try {
            $this->response = $this->client->request('POST', $this->baseUrl, [
                'form_params' => [
                    'phone_number' => $data['to'],
                    'message' => $data['message'],
                ],
            ]);
            $this->code = $this->response->getStatusCode();
        } catch (\Exception $e) {
            $this->code = $e->getCode();
        }
        return $this->code == 200;
    }
}

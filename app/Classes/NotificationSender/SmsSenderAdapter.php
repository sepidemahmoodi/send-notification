<?php
namespace App\Classes\NotificationSender;


use GuzzleHttp\Client;

class SmsSenderAdapter implements SenderAdapterInterface
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

    public function doOperation(string $to, string $subject, string $message): bool
    {
        try {
            $this->response = $this->client->request('POST', $this->baseUrl, [
                'form_params' => [
                    'phone_number' => $to,
                    'message' => $message,
                ],
            ]);
            $this->code = $this->response->getStatusCode();
        } catch (\Exception $e) {
            $this->code = $e->getCode();
        }
        return $this->code == 200;
    }
}

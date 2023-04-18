<?php
namespace App\Classes\NotificationSender;

class SmsSender implements SenderInterface
{
    private $adapter;

    public function __construct(SmsSenderAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function send(array $data): bool
    {
        return $this->adapter->doOperation($data['to'], $data['subject'] ?? 'test', $data['message']);
    }
}

<?php
namespace App\Classes\NotificationSender;

class SmsSender implements SenderInterface
{
    private $adapter;

    /**
     * SmsSender constructor.
     * @param SmsSenderAdapter $adapter
     */
    public function __construct(SmsSenderAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool
    {
        return $this->adapter->doOperation($data['to'], $data['subject'] ?? 'test', $data['message']);
    }
}

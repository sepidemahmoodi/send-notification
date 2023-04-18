<?php
namespace App\Classes\NotificationSender;

use App\Jobs\StoreNotificationInDbJob;

class SenderProcessor
{
    private SenderInterface $sender;
    private $sendStatus;

    public function __construct(SenderInterface $sender) {
        $this->sender = $sender;
    }

    public function sendProcess(array $data)
    {
        try {
            $this->sendStatus = $this->sender->send($data);
        } catch (\Exception $e) {
            $this->sendStatus = false;
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
        StoreNotificationInDbJob::dispatch(
            array_merge(['success' => $this->sendStatus], $data)
        );
    }
}

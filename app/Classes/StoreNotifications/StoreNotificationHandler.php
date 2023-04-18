<?php
namespace App\Classes\StoreNotifications;

class StoreNotificationHandler
{
    private $notification;

    public function __construct(StoreNotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function handle(array $data)
    {
        $this->notification->store($data);
    }
}

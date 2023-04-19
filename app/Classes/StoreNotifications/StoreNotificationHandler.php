<?php
namespace App\Classes\StoreNotifications;

class StoreNotificationHandler
{
    private $notification;

    /**
     * StoreNotificationHandler constructor.
     * @param StoreNotificationInterface $notification
     */
    public function __construct(StoreNotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param array $data
     */
    public function handle(array $data)
    {
        $this->notification->store($data);
    }
}

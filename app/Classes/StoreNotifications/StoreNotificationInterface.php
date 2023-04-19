<?php
namespace App\Classes\StoreNotifications;

interface StoreNotificationInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
}

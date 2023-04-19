<?php
namespace App\Classes\NotificationSender;

interface SenderInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function send(array $data);
}

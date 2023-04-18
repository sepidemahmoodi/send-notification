<?php
namespace App\Classes\NotificationSender;

interface SenderInterface
{
    public function send(array $data);
}

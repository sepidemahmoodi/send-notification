<?php
namespace App\Classes\NotificationSender;

interface SenderAdapterInterface
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return mixed
     */
    public function doOperation(string $to, string $subject, string $message);
}

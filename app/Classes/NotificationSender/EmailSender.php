<?php
namespace App\Classes\NotificationSender;

class EmailSender implements SenderInterface
{
    public function send(array $data)
    {
        try {
            mail($data['to'], $data['subject'] ?? 'send-email', $data['message']);
            return true;
        } catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}

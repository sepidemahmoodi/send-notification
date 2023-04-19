<?php
namespace App\Classes\NotificationSender;

class SenderFactory
{
    /**
     * @param $type
     * @return EmailSender|SmsSender
     * @throws \Exception
     */
    public static function choose($type) {
        switch ($type) {
            case 'sms':
                return new SmsSender(new SmsSenderAdapter('http://sendsms.com'));
            case 'email':
                return new EmailSender();
            default:
                throw new \Exception('Invalid send type');
        }
    }
}

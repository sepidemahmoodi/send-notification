<?php
namespace Tests\Unit\Classes\NotificationSender;

use App\Classes\NotificationSender\EmailSender;
use Tests\TestCase;

/**
 * @covers \App\Classes\NotificationSender\EmailSender
 */
class EmailSenderTest extends TestCase
{
    public function testSend()
    {
        $mockData = [
            'to' => 'johndoe@example.com',
            'message' => 'Hello World!',
        ];

        $sender = new EmailSender();
        $result = $sender->send($mockData);

        $this->assertTrue($result);
    }
}

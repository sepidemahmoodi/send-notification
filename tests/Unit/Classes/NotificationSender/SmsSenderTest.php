<?php
namespace Tests\Unit\Classes\NotificationSender;

use App\Classes\NotificationSender\SmsSender;
use App\Classes\NotificationSender\SmsSenderAdapter;
use Tests\TestCase;

/**
 * @covers \App\Classes\NotificationSender\SmsSender
 * @uses \App\Classes\NotificationSender\SmsSenderAdapter
 */
class SmsSenderTest extends TestCase
{
    public function testSend()
    {
        $mockData = [
            'to' => '123456789',
            'subject' => 'test',
             'message' => 'Hello World!',
        ];

        $mockAdapter = $this->createMock(SmsSenderAdapter::class);
        $mockAdapter->expects($this->once())
            ->method('doOperation')
            ->with($mockData['to'], $mockData['subject'], $mockData['message'])
            ->willReturn(true);

        $sender = new SmsSender($mockAdapter);
        $result = $sender->send($mockData);

        $this->assertTrue($result);
    }
}

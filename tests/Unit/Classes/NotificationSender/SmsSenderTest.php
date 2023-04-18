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
            'message' => 'Hello World!',
        ];

        $mockAdapter = $this->createMock(SmsSenderAdapter::class);
        $mockAdapter->expects($this->once())
            ->method('send')
            ->with($mockData)
            ->willReturn(true);

        $sender = new SmsSender($mockAdapter);
        $result = $sender->send($mockData);

        $this->assertTrue($result);
    }
}

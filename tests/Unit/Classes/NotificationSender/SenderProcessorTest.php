<?php
namespace Tests\Unit\Classes\NotificationSender;

use App\Classes\NotificationSender\SenderInterface;
use App\Classes\NotificationSender\SenderProcessor;
use Tests\TestCase;

class SenderProcessorTest extends TestCase
{
    public function testSendProcessSuccess()
    {
        $data = [
            'to' => 'john@example.com',
            'message' => 'Hello, John!',
        ];
        $senderMock = $this->createMock(SenderInterface::class);
        $senderMock->expects($this->once())
            ->method('send')
            ->with($data)
            ->willReturn(true);
        $senderProcessor = new SenderProcessor($senderMock);
        $senderProcessor->sendProcess($data);
        $status = $this->getProperty($senderProcessor, 'sendStatus');
        $this->assertTrue($status);
        $this->assertDatabaseHas('logs', ['message' => 'Hello, John!']);
    }

    public function testSendProcessFailure()
    {
        $data = [
            'to' => 'jane@example.com',
            'message' => 'Hello, Jane!',
        ];
        $senderMock = $this->createMock(SenderInterface::class);
        $senderMock->expects($this->once())
            ->method('send')
            ->with($data)
            ->willThrowException(new \Exception('Failed to send email.'));
        $senderProcessor = new SenderProcessor($senderMock);
        $this->expectException(\Exception::class);
        $senderProcessor->sendProcess($data);
        $status = $this->getProperty($senderProcessor, 'sendStatus');
        $this->assertFalse($status);
    }
}

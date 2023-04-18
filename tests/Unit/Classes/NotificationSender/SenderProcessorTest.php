<?php
namespace Tests\Unit\Classes\NotificationSender;

use App\Classes\NotificationSender\SenderInterface;
use App\Classes\NotificationSender\SenderProcessor;
use App\Jobs\StoreNotificationInDbJob;
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
        $this->assertTrue($senderProcessor->sendStatus);
        $this->assertJobDispatchedWith($data, true);
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
            ->willThrowException(new Exception('Failed to send email.'));
        $senderProcessor = new SenderProcessor($senderMock);
        $this->expectException(Exception::class);
        $senderProcessor->sendProcess($data);
        $this->assertFalse($senderProcessor->sendStatus);
        $this->assertJobDispatchedWith($data, false);
    }

    private function assertJobDispatchedWith(array $data, bool $success)
    {
        StoreNotificationInDbJob::assertDispatched(function ($job) use ($data, $success) {
            return $job->notificationData === array_merge(['success' => $success], $data);
        });
    }
}

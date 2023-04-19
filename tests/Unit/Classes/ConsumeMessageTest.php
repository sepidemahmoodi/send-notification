<?php
namespace Tests\Unit\Classes;

use App\Classes\ConsumeMessage;
use App\Jobs\ChooseMessageSenderJob;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Tests\TestCase;

class ConsumeMessageTest extends TestCase
{
    public function testConsume()
    {
        $mockConnection = $this->createMock(AMQPStreamConnection::class);

        $mockChannel = $this->createMock(\PhpAmqpLib\Channel\AMQPChannel::class);

        $mockConnection->expects($this->once())
            ->method('channel')
            ->willReturn($mockChannel);

        $mockMessage = new AMQPMessage('{"test":"data"}');
        $callback = function($message) use ($mockMessage) {
            try {
                ChooseMessageSenderJob::dispatch(json_decode($mockMessage->body, true));
            } catch(\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        };

        $mockChannel->expects($this->once())
            ->method('basic_consume')
            ->with(
                ConsumeMessage::QUEUE_NAME,
                '',
                false,
                true,
                false,
                false,
                $callback
            );

        $mockChannel->expects($this->once())
            ->method('is_consuming')
            ->willReturn(false);

        $mockChannel->expects($this->once())
            ->method('close');

        $mockChannel->expects($this->any())
            ->method('wait')
            ->willReturnCallback($callback);

        $consumeMessage = new ConsumeMessage($mockConnection);

        $result = $consumeMessage->consume();

        $this->assertEquals('Consuming process completed', $result);
    }
}

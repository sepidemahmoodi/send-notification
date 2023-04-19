<?php
namespace Tests\Unit\Classes;

use App\Classes\ConsumeMessage;
use App\Jobs\ChooseMessageSenderJob;
use Illuminate\Support\Facades\Bus;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Tests\TestCase;

class ConsumeMessageTest extends TestCase
{
    public function testConsume()
    {
        $mockConnection = $this->createMock(AMQPStreamConnection::class);
        $mockChannel = $this->createMock(AMQPChannel::class);

        $mockConnection->expects($this->any())
            ->method('channel')
            ->willReturn($mockChannel);

        $mockChannel->expects($this->once())
            ->method('basic_consume')
            ->with(
                ConsumeMessage::QUEUE_NAME,
                '',
                false,
                true,
                false,
                false,
                function ($message){
                    echo 'something';
                }
            );

        $mockChannel->expects($this->once())
            ->method('is_consuming')
            ->willReturn(false);

        $mockChannel->expects($this->once())
            ->method('close');

        $consumeMessage = new ConsumeMessage($mockConnection);

        $result = $consumeMessage->consume($mockChannel, function () {});

        $this->assertEquals('Consuming process completed', $result);
    }
}

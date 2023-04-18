<?php
namespace App\Classes;

use App\Classes\NotificationSender\SenderFactory;
use App\Classes\NotificationSender\SenderProcessor;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeMessage
{
    private $config;
    private $connection;

    const QUEUE_NAME = 'notification';

    public function __construct(array $config, AMQPStreamConnection $queueConnection)
    {
        $this->config = $config;
        $this->connection = $queueConnection;
    }

    public function consume()
    {
        $channel = $this->connection->channel();
        $callback = function ($message){
            try {
                $convertedToArrayMessage = json_decode($message->body, true);
                $senderClass = (new SenderFactory)->choose($convertedToArrayMessage['type']);
                (new SenderProcessor($senderClass))->sendProcess($convertedToArrayMessage);
            } catch(\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        };
        $channel->basic_consume(
            self::QUEUE_NAME,
            '',
            false,
            true,
            false,
            false,
            $callback
        );
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        return 'Consuming process completed';
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

<?php
namespace App\Classes;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeMessage
{
    private $connection;

    const QUEUE_NAME = 'notification';

    public function __construct(AMQPStreamConnection $queueConnection)
    {
        $this->connection = $queueConnection;
    }

    public function consume(AMQPChannel $channel, $callback)
    {
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

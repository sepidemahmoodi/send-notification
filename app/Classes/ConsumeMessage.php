<?php
namespace App\Classes;

use App\Jobs\ChooseMessageSenderJob;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeMessage
{
    private $connection;

    const QUEUE_NAME = 'notification';

    public function __construct(AMQPStreamConnection $queueConnection)
    {
        $this->connection = $queueConnection;
    }

    public function consume()
    {
        $channel = $this->connection->channel();
        $callback = function ($message){
            try {
                ChooseMessageSenderJob::dispatch(json_decode($message->body, true));
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

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

    public function __construct()
    {
        $this->config = config('database.rabbitmq');
        $this->connection = new AMQPStreamConnection(
            $this->config['host'],
            $this->config['port'],
            $this->config['login'],
            $this->config['password'],
            $this->config['vhost']
        );
    }

    public function consume()
    {
        $channel = $this->connection->channel();
        $callback = function ($message){
            try {
                $convertedToArrayMessage = $this->prepareMessageForStoring($message->body);
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

    private function prepareMessageForStoring($message)
    {
        $message = str_replace("\n", "", $message);
        $message = str_replace("\r", "", $message);
        return json_decode($message, true);
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

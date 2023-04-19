<?php

namespace App\Console\Commands;

use App\Classes\ConsumeMessage;
use App\Jobs\ChooseMessageSenderJob;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $callback = function ($message){
                try {
                    ChooseMessageSenderJob::dispatch(json_decode($message->body, true));
                } catch(\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
            };
            $config = config('database.rabbitmq');
            $connection = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['login'],
                $config['password'],
                $config['vhost']
            );
            $channel = $connection->channel();
            (new ConsumeMessage($connection))->consume($channel, $callback);
            $this->info('Messages is consumed successfully.');
            return Command::SUCCESS;
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Classes\ConsumeMessage;
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
            $config = config('database.rabbitmq');
            (new ConsumeMessage(new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['login'],
                $config['password'],
                $config['vhost']
            )))->consume();
            $this->info('Messages is consumed successfully.');
            return Command::SUCCESS;
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}

<?php

namespace App\Jobs;

use App\Classes\NotificationSender\SenderFactory;
use App\Classes\NotificationSender\SenderProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChooseMessageSenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;

    /**
     * Create a new job instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $senderClass = (new SenderFactory)->choose($this->data['type']);
        (new SenderProcessor($senderClass))->sendProcess($this->data);
    }
}

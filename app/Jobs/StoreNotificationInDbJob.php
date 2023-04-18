<?php

namespace App\Jobs;

use App\Classes\StoreNotifications\StoreNotificationHandler;
use App\Classes\StoreNotifications\StoreNotificationInDb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreNotificationInDbJob implements ShouldQueue
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
        $notificationHandler = new StoreNotificationHandler(
            new StoreNotificationInDb()
        );
        $notificationHandler->handle($this->data);
    }
}

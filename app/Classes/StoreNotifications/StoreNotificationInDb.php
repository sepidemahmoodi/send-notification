<?php
namespace App\Classes\StoreNotifications;

use Illuminate\Support\Facades\DB;

class StoreNotificationInDb implements StoreNotificationInterface
{
    public function store(array $data)
    {
        DB::table('logs')->insert([
            'type' => $data['type'] ?? '',
            'name' => $data['name'] ?? '',
            'message' => $data['message'] ?? '',
            'success' => $data['success'] ?? '',
            'sent_date' => date('Y-m-d H:i:s') ?? ''
        ]);
    }
}

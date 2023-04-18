<?php
namespace Tests\Unit\Classes\StoreNotifications;

use App\Classes\StoreNotifications\StoreNotificationInDb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNotificationInDbTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreMethodStoresDataInDatabase()
    {
        $notificationData = [
            'type' => 'email',
            'name' => 'John Doe',
            'message' => 'Test message',
            'success' => true,
        ];

        $storeNotification = new StoreNotificationInDb();
        $storeNotification->store($notificationData);

        $this->assertDatabaseHas('logs', $notificationData);
    }

    public function testStoreMethodDoesNotStoreEmptyDataInDatabase()
    {
        $notificationData = [
            'type' => 'email',
            'name' => 'John Doe',
            'message' => 'Test message',
            'success' => true,
        ];

        $storeNotification = new StoreNotificationInDb();
        $storeNotification->store($notificationData);

        $this->assertDatabaseMissing('logs', ['type' => 'sms']);
    }
}

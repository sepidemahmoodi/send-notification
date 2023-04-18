<?php
namespace Tests\Unit\Classes\StoreNotifications;

use App\Classes\StoreNotifications\StoreNotificationHandler;
use App\Classes\StoreNotifications\StoreNotificationInterface;
use Tests\TestCase;

class StoreNotificationHandlerTest extends TestCase
{
    public function testHandleMethodCallsStoreMethodOfNotificationInterface()
    {
        $notificationData = [
            'type' => 'email',
            'name' => 'John Doe',
            'message' => 'Test message',
            'success' => true,
        ];

        $mockNotification = $this->createMock(StoreNotificationInterface::class);
        $mockNotification->expects($this->once())
            ->method('store')
            ->with($notificationData);

        $storeNotificationHandler = new StoreNotificationHandler($mockNotification);
        $storeNotificationHandler->handle($notificationData);
    }
}

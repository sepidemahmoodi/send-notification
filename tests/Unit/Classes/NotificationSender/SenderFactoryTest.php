<?php
namespace Tests\Unit\Classes\NotificationSender;

use App\Classes\NotificationSender\EmailSender;
use App\Classes\NotificationSender\SenderFactory;
use App\Classes\NotificationSender\SmsSender;
use App\Classes\NotificationSender\SmsSenderAdapter;
use Tests\TestCase;

/**
 * @covers \App\Classes\NotificationSender\SenderFactory
 * @uses \App\Classes\NotificationSender\SmsSenderAdapter
 * @uses \App\Classes\NotificationSender\SmsSender
 * @uses \App\Classes\NotificationSender\EmailSender
 */
class SenderFactoryTest extends TestCase
{
    public function testChooseSmsSender()
    {
        $adapterMock = $this->getMockBuilder(SmsSenderAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory = new SenderFactory();
        $result = $factory->choose('sms');

        $this->assertInstanceOf(SmsSender::class, $result);
    }

    public function testChooseEmailSender()
    {
        $factory = new SenderFactory();
        $result = $factory->choose('email');

        $this->assertInstanceOf(EmailSender::class, $result);
    }

    public function testChooseInvalidSender()
    {
        $this->expectException(\Exception::class);

        $factory = new SenderFactory();
        $result = $factory->choose('invalid');
    }
}

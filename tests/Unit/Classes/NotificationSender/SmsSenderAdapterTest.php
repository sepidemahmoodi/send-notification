<?php
namespace Tests\Classes\NotificationSender;

use App\Classes\NotificationSender\SenderAdapterInterface;
use App\Classes\NotificationSender\SmsSenderAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/**
 * @covers \App\Classes\NotificationSender\SmsSenderAdapter
 */
class SmsSenderAdapterTest extends TestCase
{
    private $baseUrl;
    private $adapter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->baseUrl = 'https://example.com/api/send-sms';
        $this->adapter = new SmsSenderAdapter($this->baseUrl);
    }

    public function testImplementsSenderInterface()
    {
        $this->assertInstanceOf(SenderAdapterInterface::class, $this->adapter);
    }

    public function testSendSuccess()
    {
        $mockResponse = new Response(200);

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('request')
            ->with('POST', $this->baseUrl, [
                'form_params' => [
                    'phone_number' => '123456789',
                    'message' => 'Hello World!',
                ],
            ])
            ->willReturn($mockResponse);

        $this->adapter = new SmsSenderAdapter($this->baseUrl);
        $reflection = new \ReflectionClass($this->adapter);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($this->adapter, $mockClient);

        $result = $this->adapter->doOperation(
             '123456789',
            'test',
            'Hello World!'
        );
        $this->assertTrue($result);
    }

    public function testSendFailure()
    {
        $mockException = $this->createMock(\Exception::class);
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('request')
            ->willThrowException($mockException);

        $this->adapter = new SmsSenderAdapter($this->baseUrl);
        $reflection = new \ReflectionClass($this->adapter);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($this->adapter, $mockClient);

        $result = $this->adapter->doOperation(
            '123456789',
            'test',
            'Hello World!'
        );
        $this->assertFalse($result);
    }
}

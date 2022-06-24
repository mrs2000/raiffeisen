<?php

namespace tests;

use mrssoft\raiffeisen\RaifClient;
use mrssoft\raiffeisen\RaifOrder;

class QrCodeTest extends \PHPUnit\Framework\TestCase
{
    protected array $params = [];

    /**
     * @var \mrssoft\raiffeisen\RaifClient
     */
    protected RaifClient $client;

    /** @noinspection PhpSameParameterValueInspection */
    private function loadParams(string $filename): array
    {
        return json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $filename), true);
    }

    protected function setUp(): void
    {
        $this->params = $this->loadParams('params.json');

        $this->client = new RaifClient([
            'apiUrl' => 'https://test.ecom.raiffeisen.ru/api',
            'secretKey' => $this->params['secretKey'],
            'sbpMerchantId' => $this->params['sbpMerchantId'],
        ]);
    }

    private function createOrder(): RaifOrder
    {
        $order = new RaifOrder();
        $order->orderNum = md5(uniqid('raif', true));
        $order->amount = 1267.52;
        $order->description = 'Order from site';

        return $order;
    }

    public function testRegisterQr()
    {
        $order = $this->createOrder();

        $response = $this->client->registerQr(RaifClient::QR_DYNAMIC, $order);

        $this->assertNotNull($response);
        $this->assertArrayHasKey('qrId', $response);
        $this->assertArrayHasKey('payload', $response);
        $this->assertArrayHasKey('qrUrl', $response);
    }
}
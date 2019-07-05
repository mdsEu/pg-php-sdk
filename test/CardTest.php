<?php

use PHPUnit\Framework\TestCase;
use Paymentez\Paymentez;
use Paymentez\Exceptions\{
    PaymentezErrorException,
    RequestException
};

final class CardTest extends TestCase
{
    protected $service;

    public function setUp()
    {
        Paymentez::init("MAGENTO_MX_SERVER", "DKzCAv6EXXgQrC0hATOltXZ6OZ7Zss");
        $this->service = Paymentez::card();
    }

    public function testSuccessCardList()
    {
        $list = $this->service->getList(1);
        $this->assertIsObject($list->getData());
        $this->assertIsNumeric($list->result_size);
        $this->assertIsArray($list->cards);
    }

    public function testFailParamsCardList()
    {
        $this->expectException(RequestException::class);
        $this->service->getList("randomUID");
    }

    public function testFailCardList()
    {
        $this->expectException(PaymentezErrorException::class);
        Paymentez::init("1", "s");
        $service = Paymentez::card();
        $service->getList("1");
    }
}
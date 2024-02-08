<?php

namespace Punksolid\Doopla\tests;

use PHPUnit\Framework\TestCase;
use Punksolid\Doopla\Doopla;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\MockHttpClient;

class DooplaTest extends TestCase
{
    public function testIsInstantiable()
    {
        $client = new MockHttpClient();
        $this->assertInstanceOf(
            Doopla::class,
            new Doopla($client)
        );
        $this->assertTrue(true);
    }

    public function testGetAccountValue()
    {
        $this->markTestSkipped('For easy real requests purposes');
        $client = HttpClient::create();
        $doopla = new Doopla($client);
        $doopla->setEmail('');
        $doopla->setPassword('');
        $doopla->login();

        dd($doopla->getBalance());
    }
}

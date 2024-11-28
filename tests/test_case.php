<?php

use PHPUnit\Framework\TestCase;
use Hypervix\ExeclDateConverter\ExeclDateConverter;

class HelloWorldTest extends TestCase
{
    public function testSayHello()
    {
        $date = ExeclDateConverter::date('12-02-1998')->format('Y-m-d');
        $this->assertEquals('1998-02-12', $date);
    }
}
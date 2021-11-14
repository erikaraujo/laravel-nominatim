<?php

namespace ErikAraujo\Nominatim\Tests;

use ErikAraujo\Nominatim\Facades\Nominatim;

class ExampleTest extends TestCase
{
    public function testBasicExample()
    {
        $response = Nominatim::status();
        $this->assertEquals($response->status(), 200);
    }
}

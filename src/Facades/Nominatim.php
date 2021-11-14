<?php

namespace ErikAraujo\Nominatim\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ErikAraujo\Nominatim\Nominatim
 */
class Nominatim extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nominatim';
    }
}

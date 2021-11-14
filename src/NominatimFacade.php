<?php

namespace ErikAraujo\Nominatim;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ErikAraujo\Nominatim\Nominatim
 */
class NominatimFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-nominatim';
    }
}

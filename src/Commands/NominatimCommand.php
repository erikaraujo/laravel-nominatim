<?php

namespace ErikAraujo\Nominatim\Commands;

use Illuminate\Console\Command;

class NominatimCommand extends Command
{
    public $signature = 'laravel-nominatim';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

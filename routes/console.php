<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

if (App::environment('production')) {
    URL::forceScheme('https');
}

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

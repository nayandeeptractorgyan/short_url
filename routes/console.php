<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('Be inspired.');
})->purpose('Display an inspiring quote')->hourly();

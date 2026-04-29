<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('app:health', function () {
    $this->comment('Kemo Business Dashboard backend is healthy.');
})->purpose('Check backend health from CLI');

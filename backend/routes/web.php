<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['name' => 'Kemo Business Dashboard API', 'status' => 'ok']);
});

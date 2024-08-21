<?php

use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    require __DIR__ . '/categories.php';
    require __DIR__ . '/tags.php';
    require __DIR__ . '/posts.php';
});

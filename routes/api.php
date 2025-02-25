<?php

use Illuminate\Support\Facades\Route;


// Change auth:sanctum to auth:web for session authentication
Route::middleware(['auth:web'])->prefix('file-manager')->group(function () {
    

});

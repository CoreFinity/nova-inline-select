<?php

use KirschbaumDevelopment\Nova\Http\Controllers\ResourceUpdateController;
use Illuminate\Support\Facades\Route;

Route::patch('/{resource}/{resourceId}', ResourceUpdateController::class);

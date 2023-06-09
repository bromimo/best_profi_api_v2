<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\SubjectController;

Route::apiResources([
    'subjects' => SubjectController::class
]);

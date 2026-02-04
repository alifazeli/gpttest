<?php

declare(strict_types=1);

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::post('/import/marc', [ImportController::class, 'importMarc']);
Route::post('/import/ris', [ImportController::class, 'importRis']);

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/check-table', function () {
    $columns = DB::select('DESCRIBE residents');
    return response()->json($columns);
});

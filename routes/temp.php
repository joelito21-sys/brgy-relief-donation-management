<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/temp/check-table', function () {
    $columns = DB::select('SHOW COLUMNS FROM residents');
    return response()->json($columns);
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/receipt', function () {
    return view('pdf.receipt');
});

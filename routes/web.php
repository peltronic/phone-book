<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//Route::singularResourceParameters()

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/{any}', '\App\Http\Controllers\AppController@index')->name('app.index')->where('any', '.*');


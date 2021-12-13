<?php
use Illuminate\Http\Request;
//Route::singularResourceParameters()

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/{any}', '\App\Http\Controllers\AppController@index')->name('app.index')->where('any', '.*');


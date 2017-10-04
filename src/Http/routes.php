<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/person/{id}/photo',       'PersonPhotoController@show');
    });
});

Route::group(['middleware' => 'api','prefix' => 'api/v1', 'middleware' => 'throttle'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/person/{id}/photo',        'PersonPhotoController@show');
        Route::post('/person/{id}/photo',       'PersonPhotoController@store');
        Route::put('/person/{id}/photo',        'PersonPhotoController@update');
        Route::delete('/person/{id}/photo',     'PersonPhotoController@destroy');
    });
});
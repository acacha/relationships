<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function() {

    });
    Route::get('/todo',                                      'TeachersWizardController@index');
});

Route::group(['middleware' => 'api','prefix' => 'api/v1', 'middleware' => 'throttle'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/todo',                         'TeachersController@index');

    });
});
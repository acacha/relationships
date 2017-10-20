<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/person/{id}/photo',        'PersonPhotoController@show');
        Route::get('/photos/{photo}',           'PhotoController@display');

    });

    Route::get('/relationships/user/{user?}',       'UserRelationshipsController@show');

});

Route::group(['middleware' => 'api','prefix' => 'api/v1', 'middleware' => ['throttle','bindings']], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/person/{id}/photos',       'PersonPhotoController@index');
        Route::get('/person/{id}/photo',        'PersonPhotoController@show');
        Route::post('/person/{id}/photo',       'PersonPhotoController@store');
        Route::put('/person/{id}/photo',        'PersonPhotoController@update');
        Route::delete('/person/{id}/photo',     'PersonPhotoController@destroy');

        //Upload a photo for a non existing person
        Route::post('/user/{id}/photo',      'UserPhotoController@store');

        //PhotosController
        Route::delete('/photos/{photo}',     'PhotoController@delete');
        Route::put('/photos/{photo}',        'PhotoController@put');
        Route::patch('/photos/{photo}',      'PhotoController@put');

    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/relationships/user/{user?}',       'UserRelationshipsController@show');
    });

});


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

        //Persons
        Route::get('/person/{person}',          'PersonController@show');
        Route::post('/person',                  'PersonController@store');

        //Person photos
        Route::get('/person/{id}/photos',       'PersonPhotoController@index');
        Route::get('/person/{id}/photo',        'PersonPhotoController@show');
        Route::post('/person/{id}/photo',       'PersonPhotoController@store');
        Route::put('/person/{person}/photo',    'PersonPhotoController@update');
        Route::delete('/person/{id}/photo',     'PersonPhotoController@destroy');

        //Upload a photo for a non existing person
        Route::post('/user/{user}/photo',       'UserPhotoController@store');
        //Show photos for a non existing person
        Route::get('/user/{user}/photos',       'UserPhotoController@index');

        //PhotosController
        Route::delete('/photos/{photo}',        'PhotoController@delete');
        Route::post('/photos/{photo}',          'PhotoController@post');

        //IdentifierTypes
        Route::get('/identifierType',           'IdentifierTypeController@index');

        //Identifier search
        Route::get('/identifier/search',        'IdentifierSearchController@index');

        //Identifiers
        Route::get('/identifier',               'IdentifierController@index');

        //Fullnames
        Route::get('/fullname',                 'FullNameController@index');

        //Locations
        Route::get('/location',                 'LocationController@index');


    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/relationships/user/{user?}',       'UserRelationshipsController@show');
    });

});


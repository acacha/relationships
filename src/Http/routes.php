<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/person/{id}/photo',       'PersonPhotoController@show');
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

//
//        GET	/photos	index	photos.index
//GET	/photos/create	create	photos.create
//POST	/photos	store	photos.store
//GET	/photos/{photo}	show	photos.show
//GET	/photos/{photo}/edit	edit	photos.edit
//PUT/PATCH	/photos/{photo}	update	photos.update
//DELETE	/photos/{photo}	destroy	photos.destroy

        //Upload a photo for a non existing person
        Route::post('/user/{id}/photo',      'UserPhotoController@store');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/relationships/user/{user?}',       'UserRelationshipsController@show');
    });

});


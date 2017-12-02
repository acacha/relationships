<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/person/{id}/photo',        'PersonPhotoController@show');
        Route::get('/photos/{photo}',           'PhotoController@display');

    });

    Route::get('/relationships/user/{user?}',       'UserRelationshipsController@show');

});


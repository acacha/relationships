<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ListPersonPhoto;
use Acacha\Relationships\Http\Requests\ShowPersonPhoto;
use Acacha\Relationships\Http\Requests\StorePersonPhoto;
use Acacha\Relationships\Http\Requests\UpdatePersonPhoto;
use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Models\Photo;
use Illuminate\Http\Request;

/**
 * Class PersonPhotoController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class PersonPhotoController extends PhotoController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListPersonPhoto $request,$id)
    {
        $person = Person::findOrFail($id);
        return $person->photos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return mixed
     */
    public function store(StorePersonPhoto $request, $id)
    {
        return $this->storePersonPhoto($request, $id);
    }

    /**
     * Display the photo.
     *
     * @param ShowPersonPhoto $request
     * @param $id
     * @return mixed
     */
    public function show(ShowPersonPhoto $request, $id)
    {
        $photo = Person::findOrFail($id)->photos()->first();
        abort_unless($photo !=null, 404);
        return $this->showPhoto($photo);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePersonPhoto $request
     * @param Person $person
     * @return mixed
     */
    public function update(UpdatePersonPhoto $request, Person $person)
    {
        return $this->updatePersonPrimaryPhoto($request, $person->photos()->firstOrFail());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->has('all')) return $this->removeAllPersonPhotos($id);
        $photo = Person::findOrFail($id)->photos()->first();
        abort_unless($photo !=null, 404);
        $this->removePhoto($photo);
        return $photo;
    }

}

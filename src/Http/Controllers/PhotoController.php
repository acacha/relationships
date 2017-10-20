<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\DeletePhotoRequest;
use Acacha\Relationships\Http\Requests\DisplayPhotoRequest;
use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Models\Photo;
use Storage;


/**
 * Class PhotoController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class PhotoController extends Controller
{
    /**
     * DEFAULT STORAGE.
     */
    const DEFAULT_STORAGE = 'local';
    /**
     * DEFAULT PATH.
     */
    const DEFAULT_PATH = 'user_photos';

    /**
     * Display the photo.
     *
     * @param DisplayPhotoRequest $request
     * @param Photo $photo
     * @return mixed
     */
    public function display(DisplayPhotoRequest $request, Photo $photo)
    {
        return $this->showPhoto($photo);
    }

    /**
     * Destroy the photo.
     *
     * @param Photo $photo
     * @return mixed
     */
    public function delete(DeletePhotoRequest $request, Photo $photo)
    {
        $this->removePhoto($photo);
        return $photo;
    }

    /**
     * Update the photo.
     *
     * @param Photo $photo
     * @return mixed
     */
    public function put(PutPhotoRequest $request, Photo $photo)
    {
        return $this->storePersonPhoto($request, $photo);
    }

    /**
     * Remove photo.
     *
     * @param Photo $photo
     */
    protected function removePhoto(Photo $photo)
    {
        $photo->delete();
        Storage::delete($photo->path);
    }

    /**
     * Remove all person photos.
     *
     * @param $id
     * @return mixed
     */
    protected function removeAllPersonPhotos($id)
    {
        foreach ($photos = Person::findOrFail($id)->photos()->get() as $photo) {
            $this->removePhoto($photo);
        }
        return $photos;
    }

    /**
     * Get Storage.
     *
     * @param $request
     * @return array|string
     */
    protected function getStorage($request)
    {
        if ($request->has('storage')) return $request->input('storage');
        return self::DEFAULT_STORAGE;
    }

    /**
     * Get path prefix.
     *
     * @param $request
     * @return array|string
     */
    protected function getPathPrefix($request)
    {
        if ($request->has('path')) return $request->input('path');
        return self::DEFAULT_PATH;
    }

    /**
     * Get user photo filename.
     *
     * @param $request
     * @return mixed
     */
    protected function getUserPhotoFilename($request, Person $person)
    {
        // random-string-{person_id}-{fullname}.extension
        return str_random(32) . '-' . $person->id .
            '-' . snake_case($person->name) . '.' . $request->photo->getClientOriginalExtension();
    }

    /**
     * Show photo.
     *
     * @param Photo $photo
     * @return mixed
     */
    protected function showPhoto(Photo $photo)
    {
        $methodName = 'getPhotoFrom' . ucfirst($photo->storage);
        return $this->$methodName($photo);
    }

    /**
     * Get photo from local storage.
     *
     * @param Photo $photo
     * @return mixed
     */
    protected function getPhotoFromLocal(Photo $photo)
    {
        $path = storage_path('app/' . $photo->path);
        return response()->file($path);
    }

    /**
     * Store photo.
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    protected function storePersonPhoto($request, $id)
    {
        $person = Person::findOrFail($id);

        $path = $request->photo->storeAs(
            $this->getPathPrefix($request),
            $this->getUserPhotoFilename($request, $person)
        );

        $photo = $person->photos()->create([
            'storage' => $this->getStorage($request),
            'path' => $path,
            'origin' => $request->photo->getClientOriginalName()
        ]);

        return $photo;
    }

    /**
     * Update photo.
     *
     * @param $request
     * @param $photo
     * @return mixed
     */
    protected function updatePhoto($request, $photo)
    {
        if ( ! $photo instanceof Photo) $photo = Photo::findOrFail($photo);
        $path = $request->photo->storeAs(
            $this->getPathPrefix($request),
            $this->getUserPhotoFilename($request, $person = Person::findOrFail($photo->person_id))
        );

        $photo = $person->photos()->create([
            'storage' => $this->getStorage($request),
            'path' => $path,
            'origin' => $request->photo->getClientOriginalName()
        ]);

        return $photo;
    }
}

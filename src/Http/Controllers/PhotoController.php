<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\DeletePhotoRequest;
use Acacha\Relationships\Http\Requests\DisplayPhotoRequest;
use Acacha\Relationships\Http\Requests\PostPhotoRequest;
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
     * Post the photo.
     *
     * @param PostPhotoRequest $request
     * @param Photo $photo
     * @return mixed
     */
    public function post(PostPhotoRequest $request, Photo $photo)
    {
        return $this->postPhoto($request, $photo);
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
            '-' . snake_case($person->name) . '.' . $request->file->getClientOriginalExtension();
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
        return $this->storePhoto($request,Person::findOrFail($id));
    }

    /**
     * Store photo.
     *
     * @param $request
     * @param null $person
     * @return mixed
     */
    protected function storePhoto($request, $person = null)
    {
        $path = $request->file->storeAs(
            $this->getPathPrefix($request),
            $this->getUserPhotoFilename($request, $person)
        );

        return Photo::create([
            'storage' => $this->getStorage($request),
            'path' => $path,
            'origin' => $request->file->getClientOriginalName(),
            'person_id' => $person->id
        ]);
    }

    /**
     * Change stored photo.
     *
     * @param $request
     * @param $photo
     * @return mixed
     */
    protected function changeStoredPhoto($request, $photo) {
        //Add new file
        $path = $request->file->storeAs(
            $this->getPathPrefix($request),
            $this->getUserPhotoFilename($request, Person::findOrfail($photo->person_id))
        );
        //Remove old file
        Storage::disk($photo->storage)->delete($photo->path);

        return $path;
    }

    /**
     * Post photo.
     *
     * @param $request
     * @param $photo
     * @return mixed
     */
    protected function postPhoto($request, $photo)
    {
        $path = $this->changeStoredPhoto($request, $photo);

        $photo->storage = $this->getStorage($request);
        $photo->path = $path;
        $photo->origin = $request->file->getClientOriginalName();
        $photo->save();
        return $photo;
    }

    /**
     * Update photo.
     *
     * @param $request
     * @param $photo
     * @return mixed
     */
    protected function updatePersonPrimaryPhoto($request, $photo)
    {
        // When updating primary person photo we didn't remove any existing photos simple add a new main one
        if ( ! $photo instanceof Photo) $photo = Photo::findOrFail($photo);

        $path = $request->file->storeAs(
            $this->getPathPrefix($request),
            $this->getUserPhotoFilename($request, $person = Person::findOrFail($photo->person_id))
        );

        $photo = $person->photos()->create([
            'storage' => $this->getStorage($request),
            'path' => $path,
            'origin' => $request->file->getClientOriginalName()
        ]);

        return $photo;
    }
}

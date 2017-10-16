<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo.
 *
 * @package Acacha\Relationships\Models
 */
class Photo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'storage', 'path', 'origin' , 'order', 'person_id' ];

    /**
     * Get the person that owns the photo.
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}

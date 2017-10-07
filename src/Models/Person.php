<?php

namespace Acacha\Relationships\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 *
 * @package Acacha\Relationships\Models
 */
class Person extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'givenName',
        'surname',
        'surname1',
        'surname2',
        'birthdate',
        'birthplace_id',
        'gender',
        'civil_status',
        'notes'
    ];

    /**
     * The identifiers that belong to the person.
     */
    public function identifiers()
    {
        return $this->belongsToMany(Identifier::class)->withTimestamps();
    }

    /**
     * The contacts that belong to the person.
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class)->withTimestamps();
    }

    /**
     * The adresses that belong to the person.
     */
    public function addresses()
    {
        return $this->belongsToMany(Address::class)->withTimestamps();
    }

    /**
     * The users that belong to the person.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Get the person's photos.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class)->orderBy('updated_at', 'DESC');;
    }

    /**
     * Get the phone record associated with the user.
     */
    public function migration_info()
    {
        return $this->hasOne(PersonMigrationInfo::class);
    }

    /**
     * Get the person's DNI.
     *
     * @param  string  $value
     * @return string
     */
    public function getDniAttribute($value)
    {

    }
}

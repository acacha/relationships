<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Identifier.
 *
 * @package Acacha\Relationships\Models
 */
class Identifier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value','type_id'];

    /**
     * The relationships to eager load.
     *
     * @var array
     */
    public $with = ['type'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['type_name'];

    /**
     * Get the identifier's type.
     */
    public function type()
    {
        return $this->belongsTo(IdentifierType::class);
    }

    /**
     * Get the type name.
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        return $this->type->name;
    }

    /**
     * Get the person that owns the identifier.
     */
    public function person()
    {
        return $this->hasOne(Person::class);
    }

    /**
     * Get the persons that owns the identifier.
     */
    public function persons()
    {
        return $this->belongsToMany(Person::class)->withPivot('person_id');
    }

}

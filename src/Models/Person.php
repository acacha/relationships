<?php

namespace Acacha\Relationships\Models;

use Acacha\Stateful\Contracts\Stateful;
use Acacha\Stateful\Traits\StatefulTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 *
 * @package Acacha\Relationships\Models
 */
class Person extends Model implements Stateful
{
    use StatefulTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier_id',
        'givenName',
        'surname1',
        'surname2',
        'birthdate',
        'birthplace_id',
        'gender',
        'civil_status',
        'notes',
        'state'
    ];

    protected $dates = ['birthdate','created_at','updated_at'];

    /**
     * The relationships to eager load.
     *
     * @var array
     */
    public $with = ['identifier','identifiers','birthplace'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['identifier-value','identifier-type','birthplace-name','name'];

    /**
     * Transaction States
     *
     * @var array
     */
    protected $states = [
        'draft' => ['initial' => true],
        'valid' => ['final' => true],
        'completed'
    ];

    /**
     * Transaction State Transitions
     *
     * @var array
     */
    protected $transitions = [
        'complete' => [
            'from' => 'draft',
            'to' => 'completed'
        ],
        'validate' => [
            'from' => ['draft', 'completed'],
            'to' => 'valid'
        ]
    ];

    /**
     * Get the persons's fullname.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->givenName . ' ' . $this->surname1 . ' ' . $this->surname2;
    }

    /**
     * Set the user's given name.
     *
     * @param  string  $value
     * @return void
     */
    public function setGivenNameAttribute($value)
    {
        $this->attributes['givenName'] = title_case($value);
    }

    /**
     * Set the user's surname 1.
     *
     * @param  string  $value
     * @return void
     */
    public function setSurname1Attribute($value)
    {
        $this->attributes['surname1'] = title_case($value);
    }

    /**
     * Set the user's surname 2.
     *
     * @param  string  $value
     * @return void
     */
    public function setSurname2Attribute($value)
    {
        $this->attributes['surname2'] = title_case($value);
    }

    /**
     * Get the persons's identifier.
     *
     * @return string
     */
    public function getIdentifierValueAttribute()
    {
        return $this->identifier ? $this->identifier->value : '';
    }

    /**
     * Get the persons's identifier.
     *
     * @return string
     */
    public function getIdentifierTypeAttribute()
    {
        return $this->identifier ? $this->identifier->type_id : '';
    }

    /**
     * Get the persons's identifier.
     *
     * @return string
     */
    public function getBirthplaceNameAttribute()
    {
        return $this->birthplace ? $this->birthplace->name : '';
    }

    /**
     * Scope a query to only include active persons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinished($query)
    {
        //Completed and validated ones
        return $query->where('state', 'completed')->orWhere('state', 'valid');
    }

    /**
     * Create a draft person.
     */
    public static function draft()
    {
        return static::create([]);
    }

    /**
     * The birthplace that belong to the person.
     */
    public function birthplace()
    {
        return $this->belongsTo(Location::class,'birthplace_id');
    }


    /**
     * The identifier that belongs to the person.
     */
    public function identifier()
    {
        return $this->belongsTo(Identifier::class);
    }

    /**
     * The identifiers that belong to the person.
     */
    public function identifiers()
    {
        return $this->belongsToMany(Identifier::class)->withTimestamps();
    }

    /**
     * The emails that belong to the person.
     */
    public function emails()
    {
        return $this->morphedByMany(Email::class, 'contactable')->withTimestamps()->withPivot('position');
    }

    /**
     * The phones that belong to the person.
     */
    public function phones()
    {
        return $this->morphToMany(Phone::class, 'contactable')->withTimestamps();
    }

    /**
     * The mobiles that belong to the person.
     */
    public function mobiles()
    {
        return $this->morphToMany(Mobile::class, 'contactable')->withTimestamps();
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
        return $this->hasMany(Photo::class)->orderBy('updated_at', 'DESC');
    }

    /**
     * Get the phone record associated with the user.
     */
    public function migration_info()
    {
        return $this->hasOne(PersonMigrationInfo::class);
    }

}

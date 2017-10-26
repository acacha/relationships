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
        'name',
        'givenName',
        'surname',
        'surname1',
        'surname2',
        'birthdate',
        'birthplace_id',
        'gender',
        'civil_status',
        'notes',
        'state'
    ];

    /**
     * The relationships to eager load.
     *
     * @var array
     */
    public $with = ['identifiers','birthplace'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['identifier','identifier-id','identifier-type','birthplace-name'];

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
     * Get the persons's identifier.
     *
     * @return string
     */
    public function getIdentifierAttribute()
    {
        return $this->identifiers->first() ? $this->identifiers->first()->value : '';
    }

    /**
     * Get the persons's identifier.
     *
     * @return string
     */
    public function getIdentifierTypeAttribute()
    {
        return $this->identifiers->first() ? $this->identifiers->first()->type_id : '';
    }

    /**
     * Get the persons's identifier.
     *
     * @return string
     */
    public function getIdentifierIdAttribute()
    {
        return $this->identifiers->first() ? $this->identifiers->first()->id : '';
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

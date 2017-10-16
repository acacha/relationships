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
        'notes'
    ];

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
     * Create a draft person.
     */
    public static function draft()
    {
        return static::create([]);
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

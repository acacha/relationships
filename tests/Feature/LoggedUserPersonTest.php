<?php

namespace Tests\Feature;

use App;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CanSignInAsRelationshipsManager;

/**
 * Class LoggedUserPersonTest.
 *
 * @package Tests\Feature
 */
class LoggedUserPersonTest extends TestCase
{
    use RefreshDatabase,CanSignInAsRelationshipsManager;
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        App::setLocale('en');
        initialize_relationships_management_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * Show person.
     *
     * @test
     * @return void
     */
    public function show_person()
    {
        $person = create_person_with_nif();
        $user = create(User::class);
        $this->signIn($user,'api');
        $user->persons()->save($person);

        $response = $this->get('api/v1/user/person');
        $response->assertSuccessful();

        $response->assertJson([
            'id' => $person->id,
            'givenName' => $person->givenName,
            'surname1' => $person->surname1,
            'surname2' => $person->surname2,
            'birthdate' => $person->birthdate,
            'birthplace-name' => $person->birthplace_name,
            'birthplace_id' => $person->birthplace_id,
            'gender' => $person->gender,
            'identifier_id' => $person->identifier_id,
            'identifier-type' => $person->identifier_type,
            'civil_status' => $person->civil_status,
            'notes' => $person->notes,
            'updated_at' => $person->updated_at->toDateTimeString(),
            'created_at' => $person->created_at->toDateTimeString(),
        ]);
    }

    /**
     * Store person.
     *
     * @test
     * @return void
     */
    public function store_person()
    {
        $person = create_person_with_nif_array();
        $user = create(User::class);
        $this->signIn($user,'api');

        $response = $this->json('POST','api/v1/user/person/', $person);
        $response->assertSuccessful();

        $this->assertDatabaseHas('people', [
            'givenName' => $person['givenName'],
            'surname1' => $person['surname1'],
            'surname2' => $person['surname2'],
            'birthdate' => $person['birthdate'],
            'birthplace_id' => $person['birthplace_id'],
            'gender' => $person['gender'],
            'civil_status' => $person['civil_status'],
            'notes' => $person['notes'],
        ]);

        $response->assertJson([
            'givenName' => $person['givenName'],
            'surname1' => $person['surname1'],
            'surname2' => $person['surname2'],
            'birthdate' => Carbon::createFromFormat('Y-m-d H:i:s',$person['birthdate'] . ' 00:00:00')->toDateTimeString(),
            'birthplace_id' => $person['birthplace_id'],
            'gender' => $person['gender'],
            'civil_status' => $person['civil_status'],
            'notes' => $person['notes'],
            'birthplace' => [
                'id' => $person['birthplace_id'],
                'name' => $person['birthplace'],
            ]
        ]);

    }

    /**
     * Update person.
     *
     * @test
     * @return void
     */
    public function update_person()
    {
        $newPerson = create_person_with_nif_array();
        $person = create_person_with_nif();
        $user = create(User::class);
        $user->persons()->save($person);
        $this->signIn($user,'api');

        $response = $this->json('PUT','api/v1/user/person/', $newPerson);

        $response->assertSuccessful();

        $this->assertDatabaseHas('people', [
            'givenName' => $newPerson['givenName'],
            'surname1' => $newPerson['surname1'],
            'surname2' => $newPerson['surname2'],
            'birthdate' => $newPerson['birthdate'],
            'birthplace_id' => $newPerson['birthplace_id'],
            'gender' => $newPerson['gender'],
            'civil_status' => $newPerson['civil_status'],
            'notes' => $newPerson['notes'],
        ]);

        $response->assertJson([
            'givenName' => $newPerson['givenName'],
            'surname1' => $newPerson['surname1'],
            'surname2' => $newPerson['surname2'],
            'birthdate' => Carbon::createFromFormat('Y-m-d H:i:s',$newPerson['birthdate'] . ' 00:00:00')->toDateTimeString(),
            'birthplace_id' => $newPerson['birthplace_id'],
            'gender' => $newPerson['gender'],
            'civil_status' => $newPerson['civil_status'],
            'notes' => $newPerson['notes']
        ]);

    }

}
<?php

namespace Tests\Feature;

use Acacha\Relationships\Models\Identifier;
use App;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CanSignInAsRelationshipsManager;
use Tests\Traits\CheckJsonAPIUriAuthorization;

/**
 * Class PersonTest.
 *
 * @package Tests\Feature
 */
class PersonTest extends TestCase
{
    use CheckJsonAPIUriAuthorization,
        CanSignInAsRelationshipsManager,
        RefreshDatabase;
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

        $response = $this->get('api/v1/person/' . $person->id);
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
     * Check create person validation.
     *
     * @test
     * @return void
     */
    public function check_create_person_validation()
    {

        $person = [];
        $this->signInAsRelationshipsManager('api');
        $response = $this->json('POST','api/v1/person/', $person);
        $response->assertStatus(422)
        ->assertJson( [
            'message' => 'The given data was invalid.',
            'errors' => [
                'givenName' => [
                    'The given name field is required.'
                ],
                "surname1" => [
                    "The surname1 field is required."
                ],
                "identifier" => [
                    "The identifier field is required."
                ],
                "identifier_type" => [
                    "The identifier type field is required."
                ]

            ]
        ]);
    }

    /**
     * Create person.
     *
     * @test
     * @return void
     */
    public function create_person()
    {
        $person = create_person_with_nif_array();
        $this->signInAsRelationshipsManager('api');

        $response = $this->json('POST','api/v1/person/', $person);
        $response->assertSuccessful();

        $identifier_id = json_decode($response->getContent())->identifier_id;

        $this->assertDatabaseHas('people', [
            'identifier_id' => $identifier_id,
            'givenName' => $person['givenName'],
            'surname1' => $person['surname1'],
            'surname2' => $person['surname2'],
            'birthdate' => $person['birthdate'],
            'birthplace_id' => $person['birthplace_id'],
            'gender' => $person['gender'],
            'civil_status' => $person['civil_status'],
            'notes' => $person['notes'],
        ]);

        $this->assertDatabaseHas('identifiers', [
            'value'   => $person['identifier'],
            'type_id' => $person['identifier_type'],
        ]);

        // TODO state!
        // $table->enum('state',['draft','valid','completed'])->default('draft');

        $response->assertJson([
            'identifier_id' => $identifier_id,
            'givenName' => $person['givenName'],
            'surname1' => $person['surname1'],
            'surname2' => $person['surname2'],
            'birthdate' => Carbon::createFromFormat('Y-m-d H:i:s',$person['birthdate'] . ' 00:00:00')->toDateTimeString(),
            'birthplace_id' => $person['birthplace_id'],
            'gender' => $person['gender'],
            'civil_status' => $person['civil_status'],
            'notes' => $person['notes'],
            'identifier' => [
                'value' => $person['identifier']
            ],
            'identifier-type' => $person['identifier_type'],
            'birthplace' => [
               'id' => $person['birthplace_id'],
               'name' => $person['birthplace'],
            ]
        ]);

    }

    /**
     * Create person.
     *
     * @test
     * @return void
     */
    public function create_person_without_identifier()
    {
        $person = create_person();
        $person= array_merge($person, [ 'disable_validation' => true]);

        $this->signInAsRelationshipsManager('api');

        $response = $this->json('POST','api/v1/person/', $person);

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
            'identifier' => null,
            'birthplace' => [
                'id' => $person['birthplace_id'],
                'name' => $person['birthplace'],
            ]
        ]);

    }

    /**
     * Update person.
     *
     *
     * @return void
     */
    public function update_person()
    {
        $person = create_person_with_nif();
        $newPerson = create_person_with_nif_array();
        $this->signInAsRelationshipsManager('api');

        $response = $this->json('PUT','api/v1/person/' . $person->id, $newPerson);

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

        $this->assertDatabaseHas('identifiers', [
            'value'   => $newPerson['identifier'],
            'type_id' => $newPerson['identifier_type'],
        ]);


        $response->assertJson([
            'givenName' => $newPerson['givenName'],
            'surname1' => $newPerson['surname1'],
            'surname2' => $newPerson['surname2'],
            'birthdate' => Carbon::createFromFormat('Y-m-d H:i:s',$newPerson['birthdate'] . ' 00:00:00')->toDateTimeString(),
            'birthplace_id' => $newPerson['birthplace_id'],
            'gender' => $newPerson['gender'],
            'civil_status' => $newPerson['civil_status'],
            'notes' => $newPerson['notes'],
            'identifier' => [
                'value' => $person['identifier']
            ],
            'identifier-type' => $newPerson['identifier_type'],
            'birthplace' => [
                'id' => $newPerson['birthplace_id'],
                'name' => $newPerson['birthplace'],
            ]
        ]);

    }

    /**
     * Check authorization uri to show a person.
     *
     * @test
     * @return void
     */
    public function check_authorization_uri_to_show_a_person()
    {
        $person = create_person_with_nif_array();
        $this->check_json_api_uri_authorization('api/v1/person/','post', $person);
    }
}
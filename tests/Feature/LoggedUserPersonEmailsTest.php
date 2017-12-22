<?php

namespace Tests\Feature;

use App;
use App\User;
use Acacha\Relationships\Models\Email;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CanSignInAsRelationshipsManager;

/**
 * Class LoggedUserPersonEmailsTest.
 *
 * @package Tests\Feature
 */
class LoggedUserPersonEmailsTest extends TestCase
{
    use RefreshDatabase, CanSignInAsRelationshipsManager;

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
     * List emails.
     *
     * @test
     * @return void
     */
    public function list_emails()
    {
        $person = create_person_with_nif();

        $email1 = factory(Email::class)->create();
        $email2 = factory(Email::class)->create();
        $email3 = factory(Email::class)->create();

        $person->emails()->attach([$email1->id,$email2->id,$email3->id]);
        $user = create(User::class);
        $this->signIn($user,'api');
        $user->persons()->save($person);

        $response = $this->get('api/v1/user/person/emails');
        $response->assertSuccessful();
        $this->assertCount(3,json_decode($response->getContent()));
        $response->assertJsonStructure([['id','value','created_at','updated_at']]);
    }

    /**
     * Store email.
     *
     * @test
     * @return void
     */
    public function store_email()
    {
        $person = create_person_with_nif();
        $user = create(User::class);
        $this->signIn($user,'api');
        $user->persons()->save($person);

        $response = $this->post('api/v1/user/person/email',[
            'email' => 'prova1@gmail.com'
        ]);
        $id = json_decode($response->getContent())->id;
        $persons = json_decode($response->getContent())->persons;
        $response->assertSuccessful();
        $this->assertCount(1,$persons);
        $response->assertJsonStructure([ 'value', 'id','updated_at','created_at',
            'persons' => []
        ]);
        $response->assertJson([
            'value' => 'prova1@gmail.com'
        ]);

        $this->assertDatabaseHas('emails', [
            'id' => $id,
            'value' => 'prova1@gmail.com'
        ]);

        $this->assertDatabaseHas('contactables', [
            'person_id' => $person->id,
            'contactable_id' => $id,
            'contactable_type' => Email::class,
            'position' => 1
        ]);
    }

    /**
     * Store email returns 422 with user without personal data
     *
     * @test
     * @return void
     */
    public function store_email_returns_422_with_user_without_personal_data()
    {
        $user = create(User::class);
        $this->signIn($user,'api');

        $response = $this->post('api/v1/user/person/email',[
            'email' => 'prova1@gmail.com'
        ]);
        $response->assertStatus(422);
    }

    /**
     * Store email returns 422 storing already assigned email to person
     *
     * @test
     * @return void
     */
    public function store_email_returns_422_storing_already_assigned_email_to_person()
    {
        $user = create(User::class);
        $this->signIn($user,'api');
        $email1 = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $person = create_person_with_nif();
        $person->emails()->attach([$email1->id]);
        $user->persons()->save($person);

        $response = $this->post('api/v1/user/person/email',[
            'email' => 'prova1@gmail.com'
        ]);
        $response->assertStatus(422);
    }

    /**
     * Update email.
     *
     * @test
     * @return void
     */
    public function update_email()
    {
        $person = create_person_with_nif();
        $user = create(User::class);
        $user->persons()->save($person);
        $email = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $person->emails()->attach([$email->id]);
        $this->signIn($user,'api');

        $response = $this->put('api/v1/user/person/email/' . $email->id,[
            'email' => 'prova2@gmail.com'
        ]);
        $response->assertSuccessful();
        $id = json_decode($response->getContent())->id;
        $response->assertJsonStructure([ 'value', 'id','updated_at','created_at',
            'persons' => []
        ]);
        $response->assertJson([
            'value' => 'prova2@gmail.com'
        ]);

        $this->assertDatabaseHas('emails', [
            'id' => $id,
            'value' => 'prova2@gmail.com'
        ]);

        $this->assertDatabaseMissing('emails', [
            'id' => $id,
            'value' => 'prova1@gmail.com'
        ]);

        $this->assertDatabaseHas('contactables', [
            'person_id' => $person->id,
            'contactable_id' => $id,
            'contactable_type' => Email::class,
        ]);
    }

    /**
     * Cannot update not owned email.
     *
     * @test
     * @return void
     */
    public function cannot_update_not_owned_email()
    {
        $person = create_person_with_nif();
        $user = create(User::class);
        $user->persons()->save($person);
        $email = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $email2 = Email::create([
            "value" => 'prova2@gmail.com'
        ]);
        $person->emails()->attach([$email->id]);
        $this->signIn($user,'api');

        $response = $this->put('api/v1/user/person/email/' . $email2->id,[
            'email' => 'another@gmail.com'
        ]);
        $response->assertStatus(403);
    }

    /**
     * Cannot update not owned email2.
     *
     * @test
     * @return void
     */
    public function cannot_update_not_owned_email2()
    {
        $person = create_person_with_nif();
        $person2 = create_person_with_nif();
        $user = create(User::class);
        $user->persons()->save($person);
        $email = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $email2 = Email::create([
            "value" => 'prova2@gmail.com'
        ]);
        $person->emails()->attach([$email->id]);
        $person2->emails()->attach([$email2->id]);
        $this->signIn($user,'api');

        $response = $this->put('api/v1/user/person/email/' . $email2->id,[
            'email' => 'another@gmail.com'
        ]);
        $response->assertStatus(403);
    }

    /**
     * Destroy email.
     *
     * @test
     * @return void
     */
    public function destroy_email()
    {
        $user = create(User::class);
        $person = create_person_with_nif();
        $email = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $person->emails()->attach([$email->id]);
        $user->persons()->save($person);
        $this->signIn($user,'api');

        $response = $this->delete('api/v1/user/person/email/' . $email->id );
        $response->assertSuccessful();

        $this->assertDatabaseMissing('contactables', [
            'person_id' => $person->id,
            'contactable_id' => $email->id,
            'contactable_type' => Email::class,
        ]);

        $this->assertDatabaseMissing('emails', [
            'id' => $email->id,
            'value' => $email->value
        ]);
    }

    /**
     * Detach email.
     *
     * @test
     * @return void
     */
    public function detach_email()
    {
        $user = create(User::class);
        $person = create_person_with_nif();
        $person2 = create_person_with_nif();
        $email1 = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $email2 = Email::create([
            "value" => 'prova2@gmail.com'
        ]);
        $person->emails()->attach([$email1->id,$email2->id]);
        $person2->emails()->attach($email2->id);
        $user->persons()->save($person);
        $this->signIn($user,'api');

        $response = $this->delete('api/v1/user/person/email/' . $email2->id );
        $response->assertSuccessful();

        $this->assertDatabaseHas('emails', [
            'id' => $email2->id,
            'value' => $email2->value
        ]);

        $this->assertDatabaseMissing('contactables', [
            'person_id' => $person->id,
            'contactable_id' => $email2->id,
            'contactable_type' => Email::class,
        ]);
    }

    /**
     * Cannot destroy not owned email.
     *
     * @test
     * @return void
     */
    public function cannot_destroy_not_owned_email()
    {
        $user = create(User::class);
        $person = create_person_with_nif();
        $person2 = create_person_with_nif();
        $email1 = Email::create([
            "value" => 'prova1@gmail.com'
        ]);
        $email2 = Email::create([
            "value" => 'prova2@gmail.com'
        ]);
        $person->emails()->attach([$email1->id]);
        $person2->emails()->attach($email2->id);
        $user->persons()->save($person);
        $this->signIn($user,'api');

        $response = $this->delete('api/v1/user/person/email/' . $email2->id );
        $response->assertStatus(403);
    }
}
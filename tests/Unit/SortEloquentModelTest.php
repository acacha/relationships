<?php

namespace Tests\Unit;

use Acacha\Relationships\Models\Email;
use App;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SortEloquentModelTest.
 *
 * @package Tests\Unit
 */
class SortEloquentModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        App::setLocale('en');
//        initialize_relationships_management_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function todo()
    {
        $email = factory(Email::class)->create();
        $email2 = factory(Email::class)->create();
        $person = create_person_with_nif();
        $person->emails()->attach($email->id);
        $person->emails()->attach($email2->id);
//        $person->emails()->attach($email->id, ['position' => 1]);
//        $person->emails()->attach($email2->id, ['position' => 2]);
//        ['expires' => $expires]
        $this->assertCount(2,$person->emails);

//        dump($person->emails->pluck('value'));
//        dump($person->emails->pluck('order'));

        foreach ($person->emails as $email) {
            dump($email->value . ' | ' . $email->pivot->position);
//            dump($email->pivot->order);
        }

//        dump(1);
//        dd($this->person->emails);
//        dump(2);
//        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function todo2()
    {
        $email1 = factory(Email::class)->create();
        $person = create_person_with_nif();
        $person->emails()->attach([$email1->id]);

        $this->assertCount(1,$person->emails);
    }
}

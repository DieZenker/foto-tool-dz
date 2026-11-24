<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeopleTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_user_can_see_a_list_of_people()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $people = Person::factory()->count(2)->create();

        $this->actingAs($user)->get(route('people.index'))->assertStatus(200)
            ->assertSee($people[0]->name)
            ->assertSee($people[1]->name);
    }

    public function test_an_user_can_see_details_of_people()
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $files = File::factory()->count(2)->create();

        $person->files()->attach($files);

        $this->actingAs($user)
            ->get(route('people.show', $person))
            ->assertStatus(200)
            ->assertSee($person->name)
            ->assertSee($files[0]->name)
            ->assertSee($files[1]->name);
    }
}

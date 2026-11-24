<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\FileComment;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_user_can_see_file_detail_page()
    {
        $user = User::factory()->create();
        $file = File::factory()->create();

        $this->actingAs($user)
            ->get(route('file.show', $file))
            ->assertStatus(200)
            ->assertSee($file->name);
    }

    public function test_a_user_can_write_a_comment_for_a_file()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $file = File::factory()->create();

        $comment = 'Das ist ein Kommentar';

        $this->actingAs($user)
            ->post(route('file.comment', $file), ['comment' => $comment]);

        $this->assertDatabaseHas('file_comments', ['file_id' => $file->id, 'user_id' => $user->id, 'comment' => $comment]);
    }

    public function test_a_comment_will_be_shown_on_file_page()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $file = File::factory()->create();
        $fileComment = FileComment::factory()->create(['user_id' => $user->id, 'file_id' => $file->id]);

        $this->actingAs($user)
            ->get(route('file.show', $file))
            ->assertSee($fileComment->comment);
    }

    public function test_an_user_can_add_tags_to_a_file()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $file = File::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $this->actingAs($user)
            ->post(route('file.tag', $file), ['tags' => $tags->pluck('title')->toArray()]);

        foreach ($tags as $tag) {
            $this->assertDatabaseHas('file_tags', ['file_id' => $file->id, 'tag_id' => $tag->id]);
        }
    }

    public function test_an_user_can_create_and_add_tags_to_a_file()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $file = File::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $newTagName = Str::random();

        $tagNames = $tags->pluck('title')->toArray();
        $tagNames[] = $newTagName;

        $this->actingAs($user)
            ->post(route('file.tag', $file), ['tags' => $tagNames]);

        $this->assertDatabaseHas('tags', ['title' => $newTagName]);

        $tag = Tag::where('title', $newTagName)->first();

        $this->assertDatabaseHas('file_tags', ['file_id' => $file->id, 'tag_id' => $tag->id]);
    }

    public function test_an_user_can_mark_persons_on_a_file()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $file = File::factory()->create();

        $personNames = ['Hans Peter', 'Karl Heinz'];

        $this->actingAs($user)
            ->post(route('file.mark', $file), ['persons' => $personNames]);

        $this->assertDatabaseHas('people', ['name' => 'Hans Peter']);
        $this->assertDatabaseHas('people', ['name' => 'Karl Heinz']);

        $persons = \App\Models\Person::all();

        $this->assertCount(2, $persons);

        foreach ($persons as $person) {
            $this->assertDatabaseHas('file_people', ['person_id' => $person->id, 'file_id' => $file->id]);
        }

    }

    public function test_an_user_can_add_a_publication()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $file = File::factory()->create();

        $publicationDate = Carbon::now()->subDay()->format('Y-m-d H:i:s');
        $comment = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.';
        $publicationData = [
            'platform' => 'instagram',
            'link' => 'https://www.instagram.com/p/CKiW6oHJqBj/',
            'publication_date' => $publicationDate,
            'comment' => $comment
        ];

        // DB is empty. We will check if the controller creates a new platform
        $this->assertDatabaseMissing('platforms', ['name' => 'instagram']);

        $this->actingAs($user)
            ->post(route('file.publication', $file), $publicationData);

        $this->assertDatabaseHas('platforms', ['name' => 'instagram']);
        $platform = \App\Models\Platform::where('name', 'instagram')->first();
        $this->assertDatabaseHas('file_publications', ['platform_id' => $platform->id, 'file_id' => $file->id, 'publication_date' => $publicationDate, 'comment' => $comment]);
    }
}

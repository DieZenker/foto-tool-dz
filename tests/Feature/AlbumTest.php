<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_visit_album_create_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('album.create'))
            ->assertStatus(200);
    }

    public function test_a_user_can_create_an_album()
    {
        $user = User::factory()->create();

        $albumData = Album::factory()->raw();

        $this->actingAs($user)
            ->post(route('album.store'), $albumData)
            ->assertStatus(302);

        $this->assertDatabaseHas('albums', $albumData);
    }

    public function test_a_user_can_see_albums()
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();

        $this->actingAs($user)
            ->get(route('album.index'))
            ->assertSee($album->name);
    }

    public function test_an_user_can_see_album_details()
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();

        $this->actingAs($user)
            ->get(route('album.show', $album))
            ->assertStatus(200)
            ->assertSee($album->name);
    }

    public function test_an_album_shows_all_files()
    {
        $user = User::factory()->create();

        $album = Album::factory()->create();
        $files = File::factory()->count(3)->create(['album_id' => $album->id]);

        $response = $this->actingAs($user)
            ->get(route('album.show', $album))
            ->assertStatus(200);

        foreach ($files as $file)
        {
            $response->assertSee($file->name);
        }
    }

    public function test_an_album_shows_all_sub_albums()
    {
        $user = User::factory()->create();

        $album = Album::factory()->create();
        $files = File::factory()->count(3)->create(['album_id' => $album->id]);
        $subAlbums = Album::factory()->count(3)->create(['parent_id' => $album->id]);

        $response = $this->actingAs($user)
            ->get(route('album.show', $album))
            ->assertStatus(200);

        foreach ($subAlbums as $subAlbum)
        {
            $response->assertSee($subAlbum->name);
        }
    }

    public function test_an_user_can_upload_files_to_an_album()
    {
        $user = User::factory()->create();
        $album = Album::factory()->create();

        Storage::fake('uploads');

        $this->assertDatabaseCount('files', 0);

        $uploadFile1 = UploadedFile::fake()->image('image1.jpg', 702, 576);
        $uploadFile2 = UploadedFile::fake()->image('image2.jpg', 702, 576);
        $uploadFile3 = UploadedFile::fake()->image('image3.jpg', 702, 576);

        $files = [
            $uploadFile1,
            $uploadFile2,
            $uploadFile3,
        ];

        $this->actingAs($user)->post(route('album.upload'), [
            'uploads' => $files,
            'album_id' => $album->id
        ]);

        Storage::disk('uploads')->assertExists($uploadFile1->hashName());
        Storage::disk('uploads')->assertExists($uploadFile1->hashName());
        Storage::disk('uploads')->assertExists($uploadFile1->hashName());
        $this->assertDatabaseHas('files', ['file' => $uploadFile1->hashName()]);
        $this->assertDatabaseHas('files', ['file' => $uploadFile2->hashName()]);
        $this->assertDatabaseHas('files', ['file' => $uploadFile3->hashName()]);

    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_change_password()
    {
        //$this->withoutExceptionHandling();
        $password = 'password';
        $newPassword = \Str::random();
        $user = User::factory()->create(['password' => \Hash::make($password)]);

        $this->assertTrue(\Hash::check($password, $user->password));

        $this->actingAs($user)->get(route('usersettings.index'))->assertStatus(200);
        $this->actingAs($user)->post(route('usersettings.update', ['password' => $newPassword, 'password_confirmation' => $newPassword, 'oldpassword' => $password]));

        $user = $user->refresh();

        $this->assertTrue(\Hash::check($newPassword, $user->password));
    }
}

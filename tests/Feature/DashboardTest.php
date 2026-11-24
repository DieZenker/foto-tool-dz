<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_see_dashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/')->assertStatus(200);
    }
}

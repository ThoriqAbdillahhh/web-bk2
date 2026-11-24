<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/profile')->assertOk();
    }

    public function test_profile_update_and_delete_routes_are_removed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile', [])->assertStatus(405);
        $this->actingAs($user)->delete('/profile', [])->assertStatus(405);
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function home_page_is_accessible()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    /** @test */
    public function login_page_is_accessible_for_guests()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    /** @test */
    public function register_page_is_accessible_for_guests()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    /** @test */
    public function dashboard_requires_authentication()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function dashboard_is_accessible_for_authenticated_users()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_users_are_redirected_from_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function authenticated_users_are_redirected_from_register()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function logout_requires_authentication()
    {
        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
    }
}

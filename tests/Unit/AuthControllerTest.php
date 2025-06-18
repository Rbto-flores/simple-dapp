<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected AuthController $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new AuthController();
    }

    /** @test */
    public function register_validates_required_fields()
    {
        $request = Request::create('/register', 'POST', []);

        $this->expectException(ValidationException::class);

        $this->controller->register($request);
    }

    /** @test */
    public function register_validates_email_format()
    {
        $request = Request::create('/register', 'POST', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->expectException(ValidationException::class);

        $this->controller->register($request);
    }

    /** @test */
    public function register_validates_password_confirmation()
    {
        $request = Request::create('/register', 'POST', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $this->expectException(ValidationException::class);

        $this->controller->register($request);
    }

    /** @test */
    public function register_validates_minimum_password_length()
    {
        $request = Request::create('/register', 'POST', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $this->expectException(ValidationException::class);

        $this->controller->register($request);
    }

    /** @test */
    public function register_validates_unique_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $request = Request::create('/register', 'POST', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->expectException(ValidationException::class);

        $this->controller->register($request);
    }

    /** @test */
    public function login_validates_required_fields()
    {
        $request = Request::create('/login', 'POST', []);

        $this->expectException(ValidationException::class);

        $this->controller->login($request);
    }

    /** @test */
    public function login_validates_email_format()
    {
        $request = Request::create('/login', 'POST', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $this->expectException(ValidationException::class);

        $this->controller->login($request);
    }

    /** @test */
    public function controller_instance_is_correct_type()
    {
        $this->assertInstanceOf(AuthController::class, $this->controller);
    }

    /** @test */
    public function controller_has_register_method()
    {
        $this->assertTrue(method_exists($this->controller, 'register'));
    }

    /** @test */
    public function controller_has_login_method()
    {
        $this->assertTrue(method_exists($this->controller, 'login'));
    }

    /** @test */
    public function controller_has_logout_method()
    {
        $this->assertTrue(method_exists($this->controller, 'logout'));
    }
}

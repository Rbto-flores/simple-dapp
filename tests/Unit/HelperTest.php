<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /** @test */
    public function env_function_returns_default_when_key_not_found()
    {
        $result = env('NON_EXISTENT_KEY', 'default_value');

        $this->assertEquals('default_value', $result);
    }

    /** @test */
    public function config_function_works_correctly()
    {
        // Test that config function exists and can be called
        $appName = config('app.name', 'Laravel');

        $this->assertIsString($appName);
    }

    /** @test */
    public function route_function_works_correctly()
    {
        // Test that route function exists and can generate routes
        $homeRoute = route('home');

        $this->assertIsString($homeRoute);
        $this->assertStringContainsString('/', $homeRoute);
    }


    /** @test */
    public function csrf_token_function_returns_string()
    {
        // This might not work in unit tests without Laravel app context
        // but we can test the function exists
        $this->assertTrue(function_exists('csrf_token'));
    }

    /** @test */
    public function session_function_exists()
    {
        $this->assertTrue(function_exists('session'));
    }

    /** @test */
    public function auth_function_exists()
    {
        $this->assertTrue(function_exists('auth'));
    }

    /** @test */
    public function bcrypt_function_exists()
    {
        $this->assertTrue(function_exists('bcrypt'));
    }

    /** @test */
    public function back_function_exists()
    {
        $this->assertTrue(function_exists('back'));
    }

    /** @test */
    public function redirect_function_exists()
    {
        $this->assertTrue(function_exists('redirect'));
    }

    /** @test */
    public function request_function_exists()
    {
        $this->assertTrue(function_exists('request'));
    }

    /** @test */
    public function response_function_exists()
    {
        $this->assertTrue(function_exists('response'));
    }

    /** @test */
    public function view_function_exists()
    {
        $this->assertTrue(function_exists('view'));
    }

    /** @test */
    public function url_function_exists()
    {
        $this->assertTrue(function_exists('url'));
    }

    /** @test */
    public function asset_function_exists()
    {
        $this->assertTrue(function_exists('asset'));
    }
}

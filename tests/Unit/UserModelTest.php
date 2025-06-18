<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notifiable;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    /** @test */
    public function user_model_uses_correct_traits()
    {
        $user = new User();

        $this->assertContains(HasFactory::class, class_uses($user));
        $this->assertContains(Notifiable::class, class_uses($user));
    }

    /** @test */
    public function user_model_extends_authenticatable()
    {
        $user = new User();

        $this->assertInstanceOf(Authenticatable::class, $user);
    }

    /** @test */
    public function user_model_has_correct_fillable_fields()
    {
        $user = new User();
        $expected = ['name', 'email', 'password'];

        $this->assertEquals($expected, $user->getFillable());
    }

    /** @test */
    public function user_model_has_correct_hidden_fields()
    {
        $user = new User();
        $expected = ['password', 'remember_token'];

        $this->assertEquals($expected, $user->getHidden());
    }

    /** @test */
    public function user_model_has_correct_casts()
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
    }

    /** @test */
    public function user_model_table_name_is_users()
    {
        $user = new User();

        $this->assertEquals('users', $user->getTable());
    }

    /** @test */
    public function user_model_has_timestamps()
    {
        $user = new User();

        $this->assertTrue($user->usesTimestamps());
    }

    /** @test */
    public function user_model_primary_key_is_id()
    {
        $user = new User();

        $this->assertEquals('id', $user->getKeyName());
    }

    /** @test */
    public function user_model_key_type_is_int()
    {
        $user = new User();

        $this->assertEquals('int', $user->getKeyType());
    }

    /** @test */
    public function user_model_auto_incrementing_is_enabled()
    {
        $user = new User();

        $this->assertTrue($user->getIncrementing());
    }
}

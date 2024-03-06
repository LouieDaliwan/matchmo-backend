<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@test.com',
            'password' => bcrypt('johndoe')
        ]);
    }

    /**
     * @test
     */
    public function test_a_user_can_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@test.com',
            'password' => 'johndoe'
        ]);

        $auth = auth()->user();

        $response->assertStatus(201);
        $this->assertEquals('John', $auth->firstname);
        $this->assertEquals('Doe', $auth->lastname);
    }

    /**
     * @test
     */
    public function test_a_user_put_invalid_field_will_recieved_error_message()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'johndoe23@test.com',
            'password' => 'johndoe'
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Invalid credentials'
        ]);

    }
}

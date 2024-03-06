<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test.
    */
    function test_a_user_can_fill_up_the_required_details_and_register_it(): void
    {
        $this->postJson('/api/register', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'firstname' => 'John',
            'lastname' => 'Doe'
        ]);
    }

    /**
     * @test
     */
    function test_it_validates_the_fields(): void
    {
        $this->postJson('/api/register', [
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ])->assertStatus(422)
            ->assertJsonValidationErrors([
                'firstname', 'lastname', 'email', 'password'
            ]);
    }

    function test_a_user_after_registration_it_can_automatically_logged_in(): void
    {
        $this->postJson('/api/register', [
            'firstname' => 'John',
            'lastname' => 'Does',
            'email' => 'johndoe@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertStatus(201);


        $auth = auth()->user();

        $this->assertEquals('John', $auth->firstname);
        $this->assertEquals('Does', $auth->lastname);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testsRegistersUserValid()
    {
        $payload = [
            'name' => 'Babulal',
            'email' => 'babulal@gmail.com',
            'password' => 'babulal1234',
            'password_confirmation' => 'babulal1234',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
    
    public function testsRequiresPasswordEmailAndNameInvalid()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }
    
    public function testsRequirePasswordConfirmationInvalid()
    {
        $payload = [
            'name' => 'Babulal',
            'email' => 'babulal@gmail.com',
            'password' => 'babulal1234',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => ['The password confirmation does not match.'],
            ]);
    }
}

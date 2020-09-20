<?php

class RegistrationTest extends TestCase
{
    /** @test */
    public function it_returns_user_with_token_on_valid_registration()
    {
        $user = factory('App\Models\User')->make();
        $data = [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
            ]
        ];

        $response = $this->json('POST', '/api/users', $data);

        $response->assertResponseStatus(201);
        $response->seeJsonStructure([
            'user' => [
                'email',
                'name',
            ]
        ]);

        $this->assertArrayHasKey('token', $this->getResponseData()['user'], 'Token not found');
    }

    /** @test */
    public function it_returns_field_required_validation_errors_on_invalid_registration()
    {
        $data = [];

        $response = $this->json('POST', '/api/users', $data);

        $response->assertResponseStatus(422);
        $response->seeJsonEquals([
            'errors' => [
                'name' => ['field is required.'],
                'email' => ['field is required.'],
                'password' => ['field is required.'],
            ]
        ]);
    }

    /** @test */
    public function it_returns_appropriate_field_validation_errors_on_invalid_registration()
    {
        $data = [
            'user' => [
                'name' => 'invalid name',
                'email' => 'invalid email',
                'password' => '1',
            ]
        ];

        $response = $this->json('POST', '/api/users', $data);

        $response->assertResponseStatus(422);
        $response->seeJsonEquals([
            'errors' => [
                'name' => ['may only contain letters.'],
                'email' => ['must be a valid email address.'],
                'password' => ['must be at least 8 characters.'],
            ]
        ]);
    }

    /** @test */
    public function it_returns_name_and_email_taken_validation_errors_when_using_duplicate_values_on_registration()
    {
        $data = [
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'password' => $this->user->password,
            ]
        ];

        $response = $this->json('POST', '/api/users', $data);

        $response->assertResponseStatus(422);
        $response->seeJsonEquals([
            'errors' => [
                'name' => ['has already been taken.'],
                'email' => ['has already been taken.'],
            ]
        ]);
    }
}

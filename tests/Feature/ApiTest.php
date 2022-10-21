<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test getAllUsers
     */
    public function getAllUsers()
    {
        $response = $this->get('api/users');

        $response->assertStatus(200);
    }

    public function getUsersActives()
    {

        $response = $this->get('api/users?active=1');

        $response->assertStatus(200);

    }

    public function successUserLogin()
    {
        $response = $this->get('api/login');

        $response->assertStatus(200);
    }
}

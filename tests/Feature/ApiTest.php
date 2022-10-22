<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test get list of all Users
     */
    public function get_all_users()
    {
        $response = $this->get(route('users'));
        
        $response->assertStatus(200);
    }
    /**
     * @test store a new User
     *
     * @return void
     */
    public function store_new_user(){
        $response = $this->post(route('newUser'));
        
        $response->assertStatus(200);

        $response->assertSeeText(['message']);
    }

}

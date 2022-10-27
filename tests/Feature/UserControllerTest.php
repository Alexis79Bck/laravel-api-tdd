<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test register of an user
     *
     */
    public function test_user_register()
    {

        $data = [
            'fullname' => fake()->name() . ' ' . fake()->lastName(),
            'email' => fake()->freeEmail(),
            'username' => fake()->userName(),
            'password' => 'pass123456',
            'password_confirmation' => 'pass123456'
        ];

        $response = $this->post('/api/register',$data);

        $response->assertStatus(200);
    }
     /**
     * @test login of an user
     *
     */

    public function test_user_login()
    {
        $data = [
            'username' => 'realvickysanz',
            'password' => 'password',
        ];

        $response = $this->post('/api/login',$data);

        $response->assertStatus(200);

    }
    /**
     * @test show profile of an user
     *
     */
    public function test_show_auth_user_profile()
    {
        
        $response = $this->get('/api/user/profile' );

        $response->assertStatus(200);

    }
     /**
     * @test logout of an user authenticated
     *
     */
    public function test_user_logout(){
        $response = $this->get('/api/logout' );

        $response->assertStatus(200);
    }
}

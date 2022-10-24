<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * List of user records in database
     */
    public function test_get_all_users()
    {
        $users = $this->get('/api/users');

        $users->assertStatus(200);
    }
    /**
     * Get record of an user
     */
    public function test_get_user_record()
    {
        $user1 = $this->get('/api/user/1');
        $user2 = $this->get('/api/user/2');
        $user3 = $this->get('/api/user/8');
        $user4 = $this->get('/api/user/12');

        $user1->assertStatus(200);
        $user2->assertStatus(200);
        $user3->assertStatus(200);
        $user4->assertStatus(200);
    }
    /**
     * Register a new user
     */
    public function test_new_user_register()
    {
        $data1 = [
            'name' => 'Andrew Johnson',
            'email' => 'a.johnson@tester.org',
            'password' => 'nuevoAndrew'
        ];
        $data2 = [
            'name' => 'Karina Mushroom',
            'email' => 'k.mushroom@tester.org',
            'password' => 'nuevaKarina'
        ];
        $data3 = [
            'name' => 'Stewart Klause',
            'email' => 's.klause@tester.org',
            'password' => 'nuevoStewart'
        ];
        $newUser1 = $this->post('/api/register', $data1);
        $newUser2 = $this->post('/api/register', $data2);
        $newUser3 = $this->post('/api/register', $data3);

        $newUser1->assertStatus(200);
        $newUser2->assertStatus(200);
        $newUser3->assertStatus(200);


    }
    /**
     * When user login attempt is success
     */
    public function test_user_login_success()
    {
        $data1 =[
            'email' => 'k.mushroom@tester.org',
            'password' => 'nuevaKarina'
        ];

        $data2 =[
            'email' => 's.klause@tester.org',
            'password' => 'nuevoStewart'
        ];

        $data3 =[
            'email' => 'a.johnson@tester.org',
            'password' => 'nuevoAndrew'
        ];

        $data4 =[
            'email' => 'T.joe@tester.org',
            'password' => 'TTT123'
        ];

        $userLogin1 = $this->post('/api/login', $data1);
        $userLogin2 = $this->post('/api/login', $data2);
        $userLogin3 = $this->post('/api/login', $data3);
        $userLogin4 = $this->post('/api/login', $data4);

        $userLogin1->assertStatus(200);
        $userLogin2->assertStatus(200);
        $userLogin3->assertStatus(200);
        $userLogin4->assertStatus(401);
    }
}

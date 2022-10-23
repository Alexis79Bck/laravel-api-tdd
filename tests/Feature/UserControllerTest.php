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
        $users = $this->get('/users');

        $users->assertStatus(200);
    }
    /**
     * Get record of an user
     */
    public function test_get_user_record()
    {
        $user1 = $this->get('/user/1');
        $user2 = $this->get('/user/2');
        $user3 = $this->get('/user/8');
        $user4 = $this->get('/user/12');

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
        $newUser1 = $this->post('/new-user', $data1);
        $newUser2 = $this->post('/new-user', $data2);
        $newUser3 = $this->post('/new-user', $data3);

        $newUser1->assertStatus(200);
        $newUser2->assertStatus(200);
        $newUser3->assertStatus(200);


    }
}

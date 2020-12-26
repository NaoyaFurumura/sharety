<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /*
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;


    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function user_insert(){
        $user = new User();
        $user->email = "hurumura11@icloud.com";
        $user->password="bj12345";
        $user->name="naoya";
        $result = $user->save();
        $this->assertTrue($result);
    }

    public function testfactory_user(){
        $users = factory(User::class,4)->create();
        $count = count($users);
        $this->assertEquals(4, $count);
    }

}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;

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

    public function test_login(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('posts.index');
        $this->assertAuthenticated($guard = null);
    }
    
    public function test_user_insert(){
        $user = new User();
        $user->email = "hurumura11@icloud.com";
        $user->password="bj12345";
        $user->name="naoya";
        $result = $user->save();
        $this->assertTrue($result);
    }

    public function test_logout(){

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        Auth::logout();

        $this->assertGuest($guard = null);

    }

    public function testfactory_user(){
        $users = factory(User::class,4)->create();
        $count = count($users);
        $this->assertEquals(4, $count);
    }

    public function test_mypage(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('users.show',['id' => $user->id]));
        $response->assertStatus(200)->assertViewIs('users.show');
    } 

    



}

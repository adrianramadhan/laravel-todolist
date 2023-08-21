<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageforMember()
    {
        $this->withSession([
            'user' => 'adrian'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'adrian',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'adrian');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'adrian'
        ])->post('/login', [
            'user' => 'adrian',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('User or password is required');
    }

    public function testLoginError()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or password wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'adrian'
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}

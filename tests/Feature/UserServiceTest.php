<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp():void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        assertTrue($this->userService->login('adrian', 'rahasia'));
    }

    public function userNotFound()
    {
        assertFalse($this->userService->login('random', 'rahasia'));
    }

    public function testWrongPassword()
    {
        assertFalse($this->userService->login('adrian', 'wrong'));
    }
}

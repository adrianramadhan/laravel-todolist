<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            'user' => 'Adrian',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Adrian'
                ],
                [
                    'id' => '2',
                    'todo' => 'Ramadhan'
                ],
            ]
        ])->get('/todolist')
                ->assertSeeText('1')
                ->assertSeeText('Adrian')
                ->assertSeeText('2')
                ->assertSeeText('Ramadhan');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'adrian'
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'adrian'
        ])->post('/todolist', [
            'todo' => 'Ramadhan'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodoList()
    {
        $this->withSession([
            'user' => 'Adrian',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Adrian'
                ],
                [
                    'id' => '2',
                    'todo' => 'Ramadhan'
                ],
            ]
        ])->post('/todolist/1/delete')
                ->assertRedirect('/todolist');
    }
}

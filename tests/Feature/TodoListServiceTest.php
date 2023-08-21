<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodolistService::class);
    }

    public function testTodoListNotNull()
    {
        assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'Adrian');

        $todolist = Session::get('todolist');
        foreach ($todolist as $value) {
            assertEquals('1', $value['id']);
            assertEquals('Adrian', $value['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        assertEquals([], $this->todoListService->getTodoList());
    }

    public function getTodoListNotEmpty()
    {
        $expected = [
        [
            "id" => "1",
            "todo" => "Adrian"
        ],
        [
            "id" => "2",
            "todo" => "Ramadhan"
        ]
        ];

        $this->todoListService->saveTodo('1', 'Adrian');
        $this->todoListService->saveTodo('2', 'Ramadhan');

        assertEquals($expected, $this->todoListService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo('1', 'Adrian');
        $this->todoListService->saveTodo('2', 'Ramadhan');
        assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('3');
        assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('1');
        assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('2');
        assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}
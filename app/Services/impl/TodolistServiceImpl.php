<?php

namespace App\Services\Impl;

use Illuminate\Support\Facades\Session;
use App\Services\TodolistService;

class TodolistServiceImpl implements TodolistService
{
    public function saveTodo(string $id, string $todo): void
    {
        if (!Session::exists('todolist')) {
            Session::put('todolist', []);
        }

        Session::push('todolist', [
            'id' => $id,
            'todo' => $todo
        ]);
    }

    public function getTodoList(): array
    {
        return Session::get('todolist', []);
    }

    public function removeTodo(string $todoId)
    {
        $todolist = Session::get('todolist');

        foreach ($todolist as $index => $value) {
            if ($value['id'] == $todoId) {
                unset($todolist[$index]);
                break;
            }
        }

        Session::put('todolist', $todolist);
    }
}
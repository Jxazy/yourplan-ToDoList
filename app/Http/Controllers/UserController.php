<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // eloguent orm
        $class = User::all(); // select * from students
        $class2 = Note::all(); // select * from
        return view('dashboard', ['userList' => $class], ['list' => $class2]);
    }
};

<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return Note::all();
    }
}

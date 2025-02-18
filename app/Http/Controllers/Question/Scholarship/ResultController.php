<?php

namespace App\Http\Controllers\Question\Scholarship;

use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function index()
    {
        return view('pages.question.scholarship.index');
    }
}

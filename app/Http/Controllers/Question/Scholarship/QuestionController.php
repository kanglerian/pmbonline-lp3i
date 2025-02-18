<?php

namespace App\Http\Controllers\Question\Scholarship;

use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        return view('pages.question.scholarship.question');
    }
}

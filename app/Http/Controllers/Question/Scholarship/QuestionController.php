<?php

namespace App\Http\Controllers\Question\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class QuestionController extends Controller
{
    public function index(): Factory|View
    {
        return view('pages.question.scholarship.question');
    }
}

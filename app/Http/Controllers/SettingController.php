<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Factory|View
    {
        return view('pages.menu.index');
    }
}

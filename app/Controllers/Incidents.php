<?php

namespace App\Controllers;

class Incidents extends BaseController
{
    public function index(): string
    {
        return view('incidents/index');
    }
} 
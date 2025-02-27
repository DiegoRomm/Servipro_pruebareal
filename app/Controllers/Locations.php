<?php

namespace App\Controllers;

class Locations extends BaseController
{
    public function index(): string
    {
        return view('locations/index');
    }
} 
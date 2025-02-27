<?php

namespace App\Controllers;

class Inventory extends BaseController
{
    public function traps(): string
    {
        return view('inventory/traps');
    }

    public function supplies(): string
    {
        return view('inventory/supplies');
    }
} 
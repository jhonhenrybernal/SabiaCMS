<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AdminTelescopeController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/Telescope/Index', [
            'telescopeUrl' => url('/telescope'),
        ]);
    }
}

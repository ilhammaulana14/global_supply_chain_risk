<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\Port;
use App\Models\News;


class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [

            'totalUsers'     => User::count(),

            'totalCountries' => Country::count(),

            'totalPorts'     => Port::count(),

            'totalNews'      => News::count(),

        ]);
    }
}

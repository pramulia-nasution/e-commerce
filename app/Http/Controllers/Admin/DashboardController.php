<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $header = [
            'title' => 'Dashboard',
            'desc'  => 'Control Panel',
            'icon'  => ''
        ];
        return view('admin.dashboard',$header);
    }
}

<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminsController extends Controller
{
    public function index(): View
    {
        return view('admin.users.admins');
    }
}

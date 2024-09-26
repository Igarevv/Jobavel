<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Dashboard\GetSimpleAdminStatisticsAction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminHomeController extends Controller
{
    public function index(GetSimpleAdminStatisticsAction $action): View
    {
        return view('admin.main', ['statistic' => $action->handle()]);
    }
}

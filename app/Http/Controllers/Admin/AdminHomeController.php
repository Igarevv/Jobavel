<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Dashboard\GetSimpleAdminStatisticsAction as Statistics;
use App\Actions\Admin\Users\Admins\GetOnlineAdminsAction as OnlineAdmins;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminHomeController extends Controller
{
    public function index(Statistics $statistics, OnlineAdmins $admins): View
    {
        return view('admin.main', [
            'statistic' => $statistics->handle(),
            'admins' => $admins->handle()
        ]);
    }
}

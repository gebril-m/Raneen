<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rlogger;
class LogsController extends Controller
{
    public function index(){
        $logs = Rlogger::orderBy('created_at', 'desc')->get();
        $data = ['rows' => $logs];
        return view ('admin.logs.index')->with($data);
    }
}

<?php
use App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('plans' , compact('plans'));
    }
}

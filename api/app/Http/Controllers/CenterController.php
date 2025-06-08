<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index(Request $request)
    {
        $center = (new Center())->get();
        return $this->res_success('Get successfully', $center);
    }
}

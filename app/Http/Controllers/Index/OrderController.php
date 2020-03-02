<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class OrderController extends Controller
{
    public function add_order($id=''){
        return view('order/add_order');
    }
}

<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admins;
class LoginController extends Controller
{
    public function logindo(){
        $data=request()->except('_token');
        $admininfo=Admins::where(['uname'=>$data['uname']])->first();

        if($data['upwd']!==decrypt($admininfo['upwd'])){
            return redirect('/admins/login');
        }
        session(['admins'=>$admininfo]);
        request()->session()->save();
        return redirect('/admins/show');
    }
    public  function tc(){
        session(['admins'=>null]);
        request()->session()->save();
        return redirect('/admins/login');
    }
}

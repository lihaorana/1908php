<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
class LoginController extends Controller
{
    //
    public function logindo(Request $request){
        $admin=$request->except('_token');

        $res=Admin::where(['admin_name'=>$admin['admin_name']])->first();
        if($admin['admin_pwd']!=decrypt($res['admin_pwd'])){
            return redirect('/admin/login')->with('msg','用户名和密码有误');
        }else{
            session(['adminlogin'=>$res]);
            request()->session()->save();
            return redirect('shop/create');
        }
    }
}

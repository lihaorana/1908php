<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Cookie;
use App\IndexModel\User;


class LoginController extends Controller
{


    /**注册方法*/
    public function reg(){
        $data=request()->except('_token');

        $validator=Validator::make($data,[
            'u_account'=>['required','unique:user','regex:/^\d{11}$/'],
            'u_code'=>'required',
            'u_pwd'=>'required|regex:/^\w{6,8}$/',
            'u_pwd2'=>'required|regex:/^\w{6,8}$/',
        ],[
            'u_account.required'=>'账号必填',
            'u_account.unique'=>'账号已存在',
            'u_account.regex'=>'必须是数字组成11位',
            'u_code.required'=>'验证码必填',
            'u_pwd.required'=>'密码必填',
            'u_pwd.regex'=>'密码是数字字母下划线组成6-8位',
            'u_pwd2.required'=>'确认密码必填',
            'u_pwd2.regex'=>'密码是数字字母下划线组成6-8位',
        ]);

        if ($validator->fails())
        {
            return redirect('/reg')
                ->withErrors($validator)
                ->withInput();
        }

        //获取session中的账号验证码
               $session=session('CodeInfo');
        //验证账号
                if($data['u_account']!=$session['account']){
                    return redirect('/reg')->with('account','账号有误！');
                }
        //验证码验证
                if($data['u_code']!=$session['code']){
                    return redirect('/reg')->with('mag','验证码有误！');
                }
        //验证时间
                if((time()-$session['time'])>60*2){
                    return redirect('/reg')->with('mag','验证码已超时2分钟内有效！');
                }
        //验证密码
              if($data['u_pwd']!==$data['u_pwd2']){
                     return redirect('/reg')->with('msg','两次密码不一致');
              }
        unset($data['u_pwd2']);
        unset($data['u_code']);
            $data['u_pwd']=encrypt($data['u_pwd']);
        $data['add_time']=time();
        $res=User::create($data);
        if($res){
            return redirect('/login')->with('success','注册成功请登录吧！');
        }
        return redirect('/reg')->with('error','注册失败请重试');
    }

    /**登录验证*/
    public function logindo(){
        $data=request()->except('_token');
        $userinfo=User::where(['u_account'=>$data['u_account']])->first();
        if(decrypt($userinfo['u_pwd'])==$data['u_pwd']){
            session(['user'=>$userinfo]);
            request()->session()->save();
            return redirect('/');
        }else{
            return redirect('/login')->with('error','登录失败请重试');
        }
    }

    /**点击获取验证码*/
   public function getsms(){
       $u_account=request()->u_account;
       $code=rand(00000,99999);
       $info=sendSms($u_account,$code);
//        dd($info);die;
       if($info['Code']=='OK'){
           $data=['code'=>$code,'account'=>$u_account,'time'=>time()];
          session(['CodeInfo'=>$data]);
           request()->session()->save();
          return    json_encode(['code'=>1,'msg'=>'获取成功']);
       }
       return  json_encode(['code'=>2,'msg'=>'获取失败']);
   }

    public function AccountAjax(){
      $u_account=  request()->value;
        $res=User::where(['u_account'=>$u_account])->count();
        if($res>0){
            return 1;
        }else{
            return 0;
        }
    }
    /**退出登录*/
    public function unsetsession(){
        session(['user'=>null]);
//        request()->session()->forget('user');
        request()->session()->save();
        return redirect('/');
    }
}

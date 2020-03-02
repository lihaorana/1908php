@extends('layouts.shop')
@section('title', '登录页')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员登录</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->{{session('errors')}}
     <form action="{{url('/login/logindo')}}" method="post" class="reg-login">
         @csrf
         @if(empty(session('success')))
      <h3>还没有三级分销账号？点此<a class="orange" href="{{url('/reg')}}">注册</a></h3>
         @else
            <h4 style="color: red">{{session('success')}}</h4>
             @endif
      <div class="lrBox">
       <div class="lrList"><input type="text" class="account" name="u_account" placeholder="输入手机号码会员号" />
       <b style="color: red"></b>
       </div>
       <div class="lrList"><input type="text" class="pwds" name="u_pwd" placeholder="输入密码" />
           <b style="color: red"></b>
       </div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" class="submits" value="立即登录" />
      </div>
     </form><!--reg-login/-->
@endsection
<script src="/static/js/jquery.js"></script>
<script>

    //账号验证
   $(document).on('blur','.account',function(){
       var _this=$(this)
       _this.next().text('');
       var u_account=_this.val()
       if (u_account==''){
      return   _this.next().text('账号必填');
       }
       var reg=/^\d{11}$/
       if (!reg.test(u_account)){
          return _this.next().text('账号是11位手机号');
       }
   })

   //密码验证
   $(document).on('blur','.pwds',function(){
       var _this=$(this)
       _this.next().text('');
       var u_pwd=_this.val()
       if (u_pwd==''){
           return   _this.next().text('密码必填');
       }
       var reg=/^\w{6,8}$/
       if (!reg.test(u_pwd)){
         return  _this.next().text('密码格式有误!');
       }
   })

    //表单提交
    $(document).on('click','.submits',function(){
        //--账号
        $('.account').next().text('');
        var u_account=$('.account').val()
        if (u_account==''){
            return   $('.account').next().text('账号必填');
        }
        var reg=/^\d{11}$/
        if (!reg.test(u_account)){
            return $('.account').next().text('账号是11位手机号');
        }

        //--密码
        $('.pwds').next().text('');
        var u_pwd=$('.pwds').val()
        if (u_pwd==''){
            return   $('.pwds').next().text('密码必填');
        }
        var regs=/^\w{6,8}$/
        if (!regs.test(u_pwd)){
            return  $('.pwds').next().text('密码格式有误!');
        }
        $('form').submit()
    })
</script>
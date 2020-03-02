@extends('layouts.shop')

@section('title', '注册页')
@section('content')

     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('login/reg')}}" method="post" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="{{url('/login')}}">登陆</a></h3>
      <div class="lrBox">
          @csrf
       <div class="lrList">
           <b style="color:red">{{$errors->first('u_account')}}{{session('account')}}</b>
           <input type="text" name="u_account" class="account" placeholder="输入手机号码" />
       </div>
       <div class="lrList2">
           <b style="color:red">{{$errors->first('u_code')}}{{session('mag')}}</b>
           <input type="text"  name="u_code"  placeholder="输入短信验证码(获取到俩分钟内有效!)" />
           <div class="sms" style="background-color: red;width:100px;height:50px; float: right; border:1px solid ">获取验证码</div>

       </div>
       <div class="lrList">
           <b style="color:red">{{session('msg')}}{{$errors->first('u_pwd')}}</b>
           <input type="password" name="u_pwd" class="pwd" placeholder="设置新密码（6-8位数字或字母）" />
       </div>
       <div class="lrList">
           <b style="color:red">{{session('msg')}}{{$errors->first('u_pwd2')}}</b>
           <input type="password" name="u_pwd2" class="pwds" placeholder="再次输入密码" />
       </div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
@endsection
<script src="/static/js/jquery.js"></script>
<script src="/static/js/bootstrap.min.js"></script>

<script>
//    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

    //有验证码获取
       $(document).on('click','.sms',function(){
           $('input[name=u_account]').prev().text('');
         var u_account= $('input[name=u_account]').val();
         if (u_account==''){
           return  $('input[name=u_account]').prev().text('账号必填');
         }
         var reg=/^\d{11}$/
         if(!reg.test(u_account)){
             return  $('input[name=u_account]').prev().text('账号是手机号');
         }

         $.ajax({
            type:'get',
             url:'login/getsms',
             data:{u_account:u_account},
             dataType:'json',
             async:false,
             success:function(res){
//                 return console.log(res)
                 alert(res.msg)
             }
            });
     })
//账号验证
          $(document).on('blur','.account',function(){
        var _this=$(this)
        _this.prev().text('');
        var u_account= _this.val();
        if (u_account==''){
            return  _this.prev().text('账号必填');
        }
        var reg=/^\d{11}$/
        if(!reg.test(u_account)){
            return  _this.prev().text('账号是手机号');
        }
      var ajaxval=  AccountAjax(_this,u_account)
//            return   console.log(ajaxval);
              if (ajaxval==0){
                  return  _this.prev().text('ok');
              }else{
                  return  _this.prev().text('账号已注册');
              }
    })
//密码验证
          $(document).on('blur','.pwd',function(){
    var _this=$(this)
    var u_pwd= _this.val();
    if (u_pwd==''){
        return  _this.prev().text('密码必填');
    }
    var reg=/^\w{6,8}$/
    if(!reg.test(u_pwd)){
        return  _this.prev().text('密码是数字,字母,下划线,6-8位');
    }

})
//   确认密码验证
        $(document).on('blur','.pwds',function(){
    var _this=$(this)
    _this.prev().text('');
    var u_pwds= _this.val();
    if (u_pwds==''){
        return  _this.prev().text('确认密码必填');
    }

    var reg=/^\w{6,8}$/
    if(!reg.test(u_pwds)){
        return  _this.prev().text('密码是数字,字母,下划线,6-8位');
    }
    var u_pwd=$('.pwd').val()
    if (u_pwd!==u_pwds){
        return  _this.prev().text('两次密码不一致');
    }

})
//    验证账号唯一
    function AccountAjax(_this,value){
        var aa=1;
        $.ajax({
            url:"login/AccountAjax",
            type:'get',
            data:{value:value},
//            dataType:'',
            async:false,
            success:function(res){
                if(res==0){
                   aa=0
                }else{
                     aa=1
                }
            }
        });
        return aa
    }
</script>
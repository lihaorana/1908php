@extends('layouts.shop')
@section('title', '首页')
@section('content')
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
      <dl>
       <dt><a href="user.html"><img src="/static/index/images/touxiang.jpg" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="{{url('/pro')}}"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="" method="get" class="search">
      <input type="text" name="shop_name" value="{{$shop_name}}" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->
     @if(!session('user'))
     <ul class="reg-login-click">
      <li><a href="{{url('/login')}}">登录</a></li>
      <li><a href="{{url('/reg')}}" class="rlbg">注册</a></li>
      <div class="clearfix"></div>
     </ul><!--reg-login-click/-->
     @else
      <ul class="reg-login-click">
     <h5 style="color: red"><center>欢迎{{session('user.u_account')}}登录</center></h5>
      <h5 style="color:red;"><center><a href="{{url('login/unsetsession')}}">退出登录</a></center></h5>
      </ul><!--reg-login-click/-->
     @endif
     <div id="sliderA" class="slider">
         @foreach($shopinfo as $k=>$v)
                @if($v->shop_show==1&&$k!==5)
      <img src="{{env('UPLOADS_URL')}}{{$v->shop_img}}" />
             @endif
         @endforeach
     </div><!--sliderA/-->
     <ul class="pronav">
      @foreach($brandinfo as $v)
      <li><a href="{{url('/pro/'.$v->b_id)}}">{{$v->b_name}}</a></li>
  @endforeach
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     <div class="index-pro1">
    @foreach($shopinfo as  $vv)
     @if($vv->shop_show==1)
      <div class="index-pro1-list">
       <dl>
        <dt><a href="{{url('/proinfo/'.$vv->shop_id)}}"><img src="{{env('UPLOADS_URL')}}{{$vv->shop_img}}" /></a></dt>
        <dd class="ip-text"><a href="{{url('/proinfo/'.$vv->shop_id)}}">{{$vv->shop_name}}</a><span>已售0</span></dd>
        <dd class="ip-price"><strong>￥{{$vv->shop_price}}</strong></dd>
       </dl>
      </div>
       @endif
  @endforeach
      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     <div class="prolist">
@foreach($shopinfo as $vv)
 @if($vv->is_cp==1)
      <dl>
       <dt><a href="{{url('/proinfo/'.$vv->shop_id)}}"><img src="{{env('UPLOADS_URL')}}{{$vv->shop_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('/proinfo/'.$vv->shop_id)}}">{{$vv->shop_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$vv->shop_price}}</strong> </div>
        <div class="prolist-yishou"> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
       @endif
 @endforeach
     </div>

@endsection
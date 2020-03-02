@extends('layouts.shop')
@section('title', '列表')
@section('content')

     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <form action="" method="get" class="prosearch">
        <input type="text"  name="shop_name" class="get" value="{{$shop_name}}"/>
       {{--<button style="color: red ;float: right">搜索</button>--}}
       </form>
      </div>
     </header>
     <ul class="pro-select">
      <li class="li" field="is_new"><a href="javascript:;">新品</a></li>
      <li class="" field="sales"><a href="javascript:; " >销量</a></li>
      <li class="li" field="shop_price"><a href="javascript:;" >价格</a></li>
     </ul><!--pro-select/-->
     <div class="prolist">
  @foreach($shopinfo as $v)
      <dl>
       <dt><a href="{{url('/proinfo/'.$v->shop_id)}}"><img src="{{env('UPLOADS_URL')}}{{$v->shop_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('/proinfo/'.$v->shop_id)}}">{{$v->shop_name}}</a></h3>
        <div class="prolist-price"><strong>¥ {{$v->shop_price}}</div>
        <div class="prolist-yishou"> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>

         @endforeach
      {{$shopinfo->appends(['shop_name'=>$shop_name])->links()}}

     </div><!--pro/-->

@endsection
<script src="/static/js/jquery.js"></script>
<script>
    $(document).on('blur','.get',function(){
       var value= $(this).val();
            if(value!==''){
            $('form').submit();
            }
    })
// alert(121);
$(document).on('click','.pagination a',function(){
    var url=$(this).attr('href')
//    alert(url)
    $.get(
            url,
            function(res){
                $('.prolist').html(res);
            }
    )
    return false
})


    $(document).on('click','.li',function(){
        var _this=$(this)
     _this.siblings().removeClass('pro-selCur');
     _this.addClass('pro-selCur');
     var value=_this.attr('field');
//     console.log(value);
     $.get(
             '/getshop',
             {value:value},
             function(res){
//              console.log(res);
                $('.prolist').html(res);
             }
     );
    });
</script>
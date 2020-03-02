@extends('layouts.shop')
@section('title', '详情')
@section('content')
    <span name="csrf-token" content="{{ csrf_token()}}"></span>
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
         @php  $file=explode('|',$shopinfo['shop_file'])  @endphp

         @foreach($file as $vv)
      <img src="{{env('UPLOADS_URL')}}{{$vv}}" />
             @endforeach
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange">{{$shopinfo->shop_price}}</strong></th>
       <td>
           <div class="min" style=" height:30px; width:15px;float: right; border: 1px solid;margin-top: 0px ">-</div>
        <input type="text" value="1" class="spinnerExample nums" style="width: 50px;height:30px;float: right"/>
           <div class="add" style=" height:30px; width:15px;float: right; border: 1px solid;margin-top: 0px ">+</div>
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$shopinfo->shop_name}}</strong>
        <p class="hui">快把我带回家吧!</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang">
            <span  class="glyphicon glyphicon-star-empty"></span>
        </a>
       </td>
      </tr>

         <b> 该商品浏览量:{{$num??''}}</b>
     </table>
     <div class="height2"></div>
     {{--<h3 class="proTitle">商品规格</h3>--}}
     {{--<ul class="guige">--}}
      {{--<li class="guigeCur"><a href="javascript:;">50ML</a></li>--}}
      {{--<li><a href="javascript:;">100ML</a></li>--}}
      {{--<li><a href="javascript:;">150ML</a></li>--}}
      {{--<li><a href="javascript:;">200ML</a></li>--}}
      {{--<li><a href="javascript:;">300ML</a></li>--}}
      {{--<div class="clearfix"></div>--}}
     {{--</ul><!--guige/-->--}}
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="{{env('UPLOADS_URL')}}{{$shopinfo->shop_img}}" width="636" height="822" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      {{$shopinfo->shop_account}}
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a href="javascript:;" class="add_cart">加入购物车</a></td>
      </tr>

     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/static/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/static/index/js/bootstrap.min.js"></script>
    <script src="/static/index/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/static/index/js/jquery.excoloSlider.js"></script>
    <script src="/static/index/js/jquery.js"></script>
     <!--jq加减-->
    <script src="/static/index/js/jquery.spinner.js"></script>
   <script>

//               $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('span[name="csrf-token"]').attr('content')}});
       var shop_num={{$shopinfo->shop_num}}
                  shop_num= parseInt(shop_num)
        var  shop_id={{$shopinfo->shop_id}}
//	$('.spinnerExample').spinner({});
        // 失去焦点事件
       $('.nums').blur(function(){
           var _this=$(this)
           var num=_this.val();
           num= parseInt(num)
//           shop_num= parseInt(shop_num)
            if (num>=shop_num){
             num=shop_num;
            }
           if (num<=1){
             num=1
           }
           var reg=/^\d+/;
           if(!reg.test(num)){
               num=1
           }
           _this.val(num);
           changeCartnum(shop_id,num)
       })

       $('.min').click(function(){
           var _this=$(this);
           var num=_this.next().val();
//           alert(num);
           num= parseInt(num)
           if(num<=1){
           num=1;
           }else{
               num=num-1;
           }
           _this.next().val(num);
           changeCartnum(shop_id,num)
       })

       $('.add').click(function(){
           var _this=$(this);
           var num=_this.prev().val();
//           alert(num);
           num= parseInt(num)
           if(num>=shop_num){
               num=shop_num
           }else{
               num= num+1;
           }
           _this.prev().val(num);
           changeCartnum(shop_id,num)
       })
function  changeCartnum(shop_id,cart_num) {
    $.ajax({
        url: "{{url('/cart/upd_cart_nums')}}",
        data: {shop_id:shop_id,cart_num:cart_num},
        type: "get",
        dataType:'json',
        async:true,
        success: function (res) {
//                        return console.log(res)
            if (res.code == 2) {
                alert(res.msg);
            }
        }
    })
}


       var  shop_id={{$shopinfo->shop_id}}

       $('.add_cart').click(function(){
          var num= $('.nums').val();
           $.get(
                '/addcart',
                   {shop_id:shop_id,num:num},
                   function(res){
//                       return console.log(res.code);
                       if (res.code===1){
                             alert(res.msg)
                           location.href="{{url('/cart')}}";
                           return
                       }else{
                           alert(res.msg)
                       }
                   },'json'
           )
       })
	</script>
@endsection
<script src="/static/js/jquery.js"></script>
<script>
    $(document).on('click','.glyphicon',function(){
        var _this=$(this)
//     var color=_this.css('color',);
//        return alert(color)

        _this.css('color','red');
    })

</script>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>shop--购物车</title>
    <link rel="Shortcut icon" href="/favicon.ico" />

    <!-- Bootstrap -->
    <link href="/static/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/index/css/style.css" rel="stylesheet">
    <link href="/static/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    {{--<script src="http://cdn.bootcss.com/respond./static/index/js/1.4.2/respond.min.js"></script>--}}
    <![endif]-->
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>购物车</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/static/index/images/head.jpg" />
    </div><!--head-top/-->

    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：{{$count}}<strong class="orange"></strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url(/static/index/images/xian.jpg) left center no-repeat;">
                <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
            </td>
        </tr>
    </table>
    <div class="dingdanlist">
        <table>
            <tr>
                <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" class="boxs" name="1" /> 全选</a></td>
            </tr>
            @foreach($cartinfo as $k=>$v)
                    <tr shop_id="{{$v->shop_id}}">
                        <td width="4%"><input type="checkbox" class="box"  /></td>
                        <td class="dingimg" width="15%"><img src="{{env('UPLOADS_URL')}}{{$v->shop_img}}" /></td>
                        <td width="50%">
                            <h3>{{$v->shop_name}}</h3>
                            <time>下单时间：{{date("y-m-d h:i:s",$v->cart_time)}}</time>
                        </td>
                        <td align="right" shop_num="{{$v->shop_num}}">
                            <div class="min" style=" height:30px; width:15px;float: right; border: 1px solid;margin-top: 0px ">-</div>
                            <input type="text" value="{{$v->cart_num}}" class="nums" style="width: 50px;height:30px;float: right"/>
                            <div class="add" style=" height:30px; width:15px;float: right; border: 1px solid;margin-top: 0px ">+</div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4"><strong class="orange">￥{{$v->cart_num*$v->shop_price}}</strong></th>
                    </tr>
            @endforeach
            <tr>
                <td width="100%" colspan="4" class="del"><a href="javascript:;"><h4>删除</h4> </a></td>
            </tr>
        </table>
    </div><!--dingdanlist/-->
    <div class="height1"></div>
    <div class="gwcpiao">
        <table>
            <tr>
                <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
                <td width="50%">总计：<strong class="orange total">¥0</strong></td>
                <td width="40%"><a href="javascript:;" user="{{session('user')}}" class="jiesuan">去结算</a></td>
            </tr>
        </table>
    </div><!--gwcpiao/-->
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static/index/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static/index/js/bootstrap.min.js"></script>
<script src="/static/index/js/style.js"></script>
<!--jq加减-->
<script src="/static/index/js/jquery.spinner.js"></script>
<script>
           $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    //    $('.spinnerExample').spinner({});
        //	$('.spinnerExample').spinner({});
           {{--var user={{session('user')}}--}}

// 失去焦点事件
            $('.nums').blur(function(){
                var _this=$(this)
                var shop_id=_this.parents('tr').attr('shop_id');
               _this.parents('tr').find('input[class=box]').prop('checked',true);
                var shop_num=_this.parent().attr('shop_num');
                var num=_this.val();
                if (num>=shop_num){
                   num=shop_num
                }
                if (num<=1){
                      num=1;
                }
                var reg=/^\d+/;
                if(!reg.test(num)){
                    num=1;
                }
                _this.val(num)

  //        修改购买数量
                changeCartnum(shop_id,num)
//        获取小计
                changetotal(shop_id,_this);

                //       获取总价事件
                orangemoery()

            })

//点击-号是事件
    $('.min').click(function(){
        var _this=$(this);
        var shop_id=_this.parents('tr').attr('shop_id');
        _this.parents('tr').find('input[class=box]').prop('checked',true);
        var shop_num=_this.parent().attr('shop_num');
        var num=_this.next().val();
//           alert(num);
        num= parseInt(num)
        shop_num= parseInt(shop_num)
        if(num<=1){
              num=1;
        }else{
            num= num-1;
        }
        _this.next().val(num);

//        修改购买数量
        changeCartnum(shop_id,num)
        //        获取小计
        changetotal(shop_id,_this);
//        获取总价
        orangemoery()
    })

//点击+号是事件
    $('.add').click(function(){
        var _this=$(this);
        _this.parents('tr').find('input[class=box]').prop('checked',true);
        var shop_id=_this.parents('tr').attr('shop_id');
//        alert(shop_id);
        var shop_num=_this.parent().attr('shop_num');

        var num=_this.prev().val();
            num= parseInt(num)
            shop_num= parseInt(shop_num)
//           alert(num);
        //alert(num);return;
        if(num>=shop_num){
            num=shop_num;
        }else{
             num= num+1;
        }
        _this.prev().val(num);
//        修改购买数量
        changeCartnum(shop_id,num)
//        获取小计
        changetotal(shop_id,_this);

//   获取总价
        orangemoery()

    })

//全选事件
    $('.boxs').click(function(){
            var  _this=$(this)
             var checked= _this.prop('checked')
                    if (checked==true){
                        $('.box').prop('checked',true);
                    }else{
                        $('.box').prop('checked',false);
                    }
//获取总价
        orangemoery()
            });

//  点击复选框时
         $('.box').click(function(){
             orangemoery();
         })

//批量删除
        $('.del').click(function(){
            var checked= $('.box:checked')

            var shop_id=''
                checked.each(function(index){
                  shop_id+=$(this).parents('tr').attr('shop_id')+',';
                })
            if (shop_id==''){
                 alert('请至少选择一件商品');
                return
            }
            if (window.confirm('不在想想吗? ')){
                shop_id= shop_id.substr(0,shop_id.length-1);
                delshop(shop_id)
            }
            orangemoery()
        })

/**获取总价*/
         function orangemoery(){
           var checked= $('.box:checked')
           var shop_id=''
           checked.each(function(index){
            shop_id+=$(this).parents('tr').attr('shop_id')+',';
           })
        if (shop_id==''){
            return    $('.total').text('￥0')
        }
           shop_id= shop_id.substr(0,shop_id.length-1);
        getmoery(shop_id)
    }

//获取总价--ajax
           function getmoery(shop_id){
               $.ajax({
                   url:"{{url('/cart/getmoery')}}",
                   data:{shop_id:shop_id},
                   type:"post",
                   dataType:'json',
                   async:false,
                   success:function(res){
//                return console.log(res)
                       if (res.code==1){
                     return    $('.total').text('￥'+res.msg);
                       }
                       return alert(res.msg);
                   }
               })
           }

//    修改购买数量
            function  changeCartnum(shop_id,cart_num) {
                $.ajax({
                    url: "{{url('/cart/upd_cart_num')}}",
                    data: {shop_id:shop_id,cart_num:cart_num},
                    type: "post",
                    dataType:'json',
                    async: false,
                    success: function (res) {
//                        return console.log(res)
                        if (res.code == 2) {
                            alert(res.msg);
                        }
                    }
                })
            }

 /**改变小计*/
           function changetotal(shop_id,_this){
               $.ajax({
                   url:"{{url('/cart/getnewtotal')}}",
                   data:{shop_id:shop_id},
                   type:"post",
                   dataType:'json',
                   async:false,
                   success:function(res){
                       if (res.code==1){
                 _this.parents('tr').next().find('strong').html('￥'+res.msg);
                       }else{
                           alert(res.msg)
                       }
                   }
               })
           }

//   删除
                function  delshop(shop_id){
                    $.ajax({
                        url:"{{url('/cart/del')}}",
                        data:{shop_id:shop_id},
                        type:"post",
                        dataType:'json',
                        async:false,
                        success:function(res){
            //                return console.log(res)
                            if (res.code==1){
                             return   location.reload()
                            }
                           return alert(res.msg);
                        }
                    })
                }
/**账单结算*/
                $('.jiesuan').click(function(){
                    var checked= $('.box:checked')
                    var shop_id=''
                    checked.each(function(index){
                        shop_id+=$(this).parents('tr').attr('shop_id')+',';
                    })

                    if (shop_id==''){
                        return  alert('请至少选择一件商品');
                    }
                    shop_id= shop_id.substr(0,shop_id.length-1);
                    var user=$(this).attr('user');
//                   return  alert(user);u
                    if(user==''){
                    {{--location.href="{{}}";--}}
                    return   alert('请登录');
                    }
                   var code= checkmoery();
                    if(code==1){
                 location.href="{{url('order')}}"+'/'+shop_id;
                    }else if(code==3){
                        location.href="{{url('/add_address/')}}"+'/'+shop_id;
                    }else{
                       return alert('非法操作请登录');
                    }
                })

//  账单结算--ajax
               function checkmoery(){
                   var code=0
                   $.ajax({
                       url:"{{url('/is_address')}}",
//                       data:{user:user},
                       type:"post",
                       dataType:'json',
                       async:false,
                       success:function(res){
//                    return console.log(res)
                           if (res.code==1){
                                code=1
                           }else if (res.code==3){
                              code=3
                           }
                            alert(res.msg);
                       }
                   })
                   return code;
               }
</script>
</body>
</html>
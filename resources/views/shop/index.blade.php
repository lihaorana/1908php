<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<form action="">
    <input type="text" name="shop_name" value="{{$shop_name??''}}" placeholder="请输入商品名称搜索">
    品牌:
    <select name="b_id" id="">
        <option value="">-请输入-</option>
        @foreach($brandinfo as $k=>$v)
            <option value="{{$v->b_id}}"  @if($b_id==$v->b_id)selected @endif>{{$v->b_name}}</option>
        @endforeach
    </select>
    分类:
    <select name="cate_id" id="">
        <option value="">-请输入-</option>
        @foreach($cateinfo as $k=>$v)
            <option value="{{$v['cate_id']}}"  @if($cate_id==$v['cate_id'])selected @endif>
                {!! str_repeat('&nbsp;&nbsp;',$v['level']*3)!!}{{$v['cate_name']}}</option>
        @endforeach
    </select>
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>商品id</td>
        <td>商品名称</td>
        <td>商品库存</td>
        <td>商品价格</td>
        <td>商品分类</td>
        <td>商品品牌</td>
        <td>是否热卖</td>
        <td>是否首页展示</td>
        <td>是否新品</td>
        <td>商品图片</td>
        <td>商品相册</td>
        <td>操作</td>
    </tr>
    @foreach($info as $k=>$v)
    <tr shop_id="{{$v->shop_id}}">
        <td>{{$v->shop_id}}</td>
        <td>{{$v->shop_name}}</td>
        <td>{{$v->shop_num}}</td>
        <td>{{$v->shop_price}}</td>
        <td>{{$v->cate_name}}</td>
        <td>{{$v->b_name}}</td>
        <td>@if($v->is_cp==1)是 @else 否 @endif</td>
        <td>@if($v->shop_show==1)是 @else 否 @endif</td>
        <td>@if($v->is_new==1)是 @else 否 @endif</td>
       <td>
            <img src="{{env('UPLOADS_URL')}}{{$v->shop_img}}" height="50px" width="50px">
        </td>
        <td>
            @if($v->shop_file)
                @php   $shop_file=explode('|',$v->shop_file);   @endphp
            @foreach($shop_file as $vv)
            <img src="{{env('UPLOADS_URL')}}{{$vv}}" height="20px" width="20px">
                @endforeach
                @endif
        </td>
        <td>
            <a href="javascript:void(0)" class="del" shop_id="{{$v->shop_id}}">删除</a>
            <a href="{{url('shop/edit/'.$v->shop_id)}}">修改</a>
        </td>
    </tr>
        @endforeach
</table>
{{$info->appends(['b_id'=>$b_id,'cate_id'=>$cate_id,'shop_name'=>$shop_name])->links()}}
</body>
<script src="/static/js/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $(document).on('click','.del',function(){
      var _this=$(this);
       var shop_id= _this.attr('shop_id');
        if (confirm('确定删除吗?')) {
            $.post(
                    "/shop/destroy/"+shop_id,
                    function (res) {
//                    return    console.log(res);
                        if (res.code==00000){
                            location.reload();
                            alert('已删除');
                        }else{
                            alert('删除失败');
                        }
                    }, 'json'
            )
        }
   })
</script>
</html>
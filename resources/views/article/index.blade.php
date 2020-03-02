<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<form action="">
    <input type="text" name="n_title" value="{{$n_title}}" placeholder="请输入搜索">
    <select name="a_id" id="">
        <option value="">-请输入-</option>
        @foreach($data as $k=>$v)
            <option value="{{$v->a_id}}"  @if($a_id==$v->a_id)selected @endif>{{$v->a_name}}</option>
        @endforeach
    </select>
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>id</td>
        <td>标题</td>
        <td>分类</td>
        <td>重要性</td>
        <td>是否显示</td>
        <td>图片</td>
        <td>操作</td>
    </tr>
    @foreach($info as $k=>$v)
    <tr n_id="{{$v->n_id}}">
        <td>{{$v->n_id}}</td>
        <td>{{$v->n_title}}</td>
        <td>{{$v->a_name}}</td>
        <td>@if($v->is_zy==1)普通 @else 置顶 @endif</td>
        <td>@if($v->is_show==1)是 @else 否 @endif</td>
        <td>{{date('y-m-d h:i:s',$v->n_time)}}</td>
       <td><img src="{{env('UPLOADS_URL')}}{{$v->n_img}}" height="50px" width="50px"></td>
        <td>
            <a href="javascript:void(0)" class="del" n_id="{{$v->n_id}}">删除</a>
            <a href="{{url('article/edit/'.$v->n_id)}}">修改</a>
        </td>
    </tr>
        @endforeach
</table>
{{$info->appends(['n_title'=>$n_title,'a_id'=>$a_id])->links()}}
</body>
<script src="/static/js/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $(document).on('click','.del',function(){
      var _this=$(this);
       var n_id= _this.attr('n_id');
        if (confirm('确定删除吗?')) {
            $.post(
                    "/article/destroy/"+n_id,
                    function (res) {
                        if (res.code==00000){
                            location.reload();
//                            alert('ok');
                        }else{
                            alert('删除失败');
                        }
                    }, 'json'
            )
        }
   })
</script>
</html>
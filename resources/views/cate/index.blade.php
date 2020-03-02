<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<center><h3>分类列表</h3>
        <table border="1">
            <tr>
                <td>分类名称</td>
                <td>操作</td>
            </tr>
        @foreach($info as $k=>$v)
            <tr cate_id="{{$v['cate_id']}}" p_id="{{$v['p_id']}}" >

                <td class="form-contro1"> <b>+</b>{!! str_repeat('&nbsp;&nbsp;',$v['level']*3)!!}{{$v['cate_name']}}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-default btn-xs del">删除</a>
                    <a href="{{url('cate/edit/'.$v['cate_id'])}}" class="btn btn-default btn-xs">修改</a>
                </td>
            </tr>
            @endforeach
        </table>
</center>
</body>
<script>


//    $('b').click(function(){
//        var _this=$(this)
//        var value=_this.text();
//        if (value=='+'){
//
//        }
//    })

   $('.del').click(function(){
       var _this=$(this)
    var cate_id=_this.parents('tr').attr('cate_id');
       $.get(
               '/cate/destroy/'+cate_id,
               function(res){
                  if (res.code==1){
                _this.parents('tr').remove();
                     return  alert(res.msg);
                  }else{
                   return   alert(res.msg);
                  }

               },'json'

       );
   })
</script>
</html>
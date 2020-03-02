<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr>
        <td>id</td>
        <td>管理员账号</td>
        <td>管理员头像</td>
        <td>管理员手机号</td>
        <td>管理员邮箱</td>
        <td>操作</td>
    </tr>
    @foreach($info as $v)
    <tr>
        <td>{{$v->admin_id}}</td>
        <td>{{$v->admin_name}}</td>
        <td><img src="{{env('UPLOADS_URL')}}{{$v->admin_img}}" height="50px" width="50px"></td>
        <td>{{$v->admin_tel}}</td>
        <td>{{$v->admin_email}}</td>
        <td>
            <a href="{{url('admin/edit/'.$v->admin_id)}}">修改</a>  ||
            <a href="{{url('admin/destroy/'.$v->admin_id)}}">删除</a>
        </td>
    </tr>
        @endforeach
</table>

</body>
</html>
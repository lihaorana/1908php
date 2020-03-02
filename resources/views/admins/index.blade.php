<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
@if(session('admins.is_super')==1)<h3>您是主管理员</h3> @else <h3>您是普通管理员</h3>@endif
<h4><a href="{{url('/admins/tc')}}">退出登录</a></h4>
<table border="1">
    <tr>
        <td>管理员id</td>
        <td>管理员昵称</td>
        <td>库管是否主管</td>
        <td>管理用户</td>
        <td>管理货物</td>
        <td>管理入库</td>
        <td>操作</td>
    </tr>
    @foreach($info as $v)
    <tr>
        <td>{{$v->uid}}</td>
        <td>{{$v->uname}}</td>
        <td>{{$v->is_super==1?'主管':'普通'}}</td>
        <td>{{$v->is_user==1?'有':'没有'}}</td>
        <td>{{$v->is_depot==1?'有':'无'}}</td>
        <td>{{$v->is_cargo==1?'有':'无'}}</td>
        <td>
            @if(session('admins.is_super')==1)
                @if($v->is_super==2)
            <a href="{{url('/admins/destroy/'.$v->uid)}}">删除</a>
            <a href="{{url('/admins/edit/'.$v->uid)}}">修改</a>
                    @endif
                @else
                无权限
            @endif
        </td>
    </tr>
        @endforeach
</table>
    @if(session('admins.is_super')==1)
    <a href="{{url('/admins/create')}}">去添加管理员</a>
        @endif
</center>
</body>
</html>
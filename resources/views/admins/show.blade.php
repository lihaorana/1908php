<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
    @if(session('admins.is_super')==1)<h3>主管理员</h3> @else <h3>您是普通管理员</h3>@endif
@if(session('admins.is_super')==1)
    <a href="{{url('/admins/index')}}">用户管理</a>
    @endif
    <a href="{{url('/admins/index')}}">货物管理页面</a>
    <a href="{{url('/admins/index')}}">出入库管理</a>
</center>

</body>
</html>
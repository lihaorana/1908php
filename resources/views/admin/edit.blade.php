<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
   <center><h3>管理员修改</h3>
<form action="{{url('admin/update/'.$info->admin_id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <table border="1">
        <tr>
            <td>账号</td>
            <td><input type="text" name="admin_name" value="{{$info->admin_name}}" placeholder="请添加账号">
                <b style="color: red">{{$errors->first('admin_name')}}</b>
            </td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" name="admin_pwd" value="{{$info->admin_pwd}}" placeholder="请输入密码">
                <b style="color: red">{{$errors->first('admin_pwd')}}</b>
            </td>
        </tr>
        <tr>
            <td>确认密码</td>
            <td><input type="password" name="admin_pwd2" value="{{$info->admin_pwd}}" placeholder="请确定密码">
                <b style="color: red">{{$errors->first('admin_pwd2')}}</b>
            </td>
        </tr>
        <tr>
            <td>手机号</td>
            <td><input type="tel" name="admin_tel" value="{{$info->admin_tel}}" placeholder="请输入手机号">

            </td>
        </tr>
        <tr>
            <td>邮箱</td>
            <td><input type="email" name="admin_email" value="{{$info->admin_email}}" placeholder="请输入邮箱">

            </td>
        </tr>
        <tr>
            <td>管理员头像</td>
            <td><input type="file" name="admin_img">
            <img src="{{env('UPLOADS_URL')}}{{$info->admin_img}}" width="50px" height="50px">
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="修改"></td>
            <td></td>
        </tr>
    </table>
</form>
   </center>
</body>
</html>
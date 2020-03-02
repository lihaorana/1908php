<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
    <h3>库管理员登录</h3>
<form action="{{url('/admins/logindo')}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>库管用户名</td>
            <td><input type="text" name="uname"></td>
        </tr>
        <tr>
            <td>库管密码</td>
            <td><input type="password" name="upwd"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="登录"></td>
        </tr>
    </table>
</form>
</center>
</body>
</html>
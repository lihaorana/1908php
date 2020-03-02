<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h2>库管员添加</h2>
<form action="{{'/admins/store'}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>管理员昵称</td>
            <td><input type="text" name="uname"></td>
        </tr>
        <tr>
            <td>管理员密码</td>
            <td>
                <input type="password" name="upwd">
            </td>
        </tr>
        <tr>
            <td>是否是库管主管</td>
            <td>
                <input type="radio" name="is_super" value="1">是
                <input type="radio" name="is_super" value="2" checked>否
            </td>
        </tr>
        <tr>
            <td><input type="submit"   value="添加"></td>
            <td></td>
        </tr>
    </table>
</form>
</center>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center><h2>库管员修改</h2>
<form action="{{'/admins/update/'.$info->uid}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>管理员昵称</td>
            <td><input type="text" name="uname" value="{{$info->uname}}"></td>
        </tr>

        <tr>
            <td>是否是库管主管</td>
            <td>
                <input type="radio" name="is_super" value="1" {{$info->is_super==1?'checked':''}}>是
                <input type="radio" name="is_super" value="2" {{$info->is_super==2?'checked':''}}>否
            </td>
        </tr>
        <tr>
            <td><input type="submit"   value="修改"></td>
            <td></td>
        </tr>
    </table>
</form>
</center>
</body>
</html>
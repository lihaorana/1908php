<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('/brand/store')}}" method="post" enctype="multipart/form-data">
    <table border="1">
        @csrf
        <tr>
            <td>品牌名称</td>
            <td>
                <input type="text" name="b_name" placeholder="请输入名称">
               <b style="color: red">{{$errors->first('b_name')}}</b>
            </td>
        </tr>
        <tr>
            <td>品牌logo</td>
            <td>
                <input type="file" name="b_logo">
            </td>
        </tr>
        <tr>
            <td>品牌网址</td>
            <td>
                <input type="text" name="b_url">
                <b style="color: red">{{$errors->first('b_url')}}</b>
            </td>
        </tr>
        <tr>
            <td>品牌描述</td>
            <td>
                <textarea name="b_account" id="" cols="30" rows="10"></textarea>
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="添加"></td>
            <td></td>
        </tr>
    </table>
</form>
</center>
</body>
</html>
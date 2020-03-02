<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('/brand/update/'.$data->b_id)}}" method="post" enctype="multipart/form-data">
    <table border="1">
        @csrf
        <tr>
            <td>品牌名称</td>
            <td>
                <input type="text" name="b_name" value="{{$data->b_name}}" placeholder="请输入名称">
                <b style="color: red">{{$errors->first('b_name')}}</b>
            </td>
        </tr>
        <tr>
            <td>品牌logo</td>
            <td>
                <input type="file" name="b_logo">
                <img src="{{env('UPLOADS_URL')}}{{$data->b_logo}}" width="50px" height="50px">
            </td>
        </tr>
        <tr>
            <td>品牌网址</td>
            <td>
                <input type="text" name="b_url" value="{{$data->b_url}}">
                <b style="color: red">{{$errors->first('b_url')}}</b>
            </td>
        </tr>
        <tr>
            <td>品牌描述</td>
            <td>
                <textarea name="b_account"  cols="30" rows="10">{{$data->b_account}}</textarea>
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="编辑"></td>
            <td></td>
        </tr>
    </table>
</form>
</center>
</body>
</html>
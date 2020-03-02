<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('/study/store')}}" method="post" enctype="multipart/form-data">
    <table border="1">
        @csrf
        <tr>
            <td>学生姓名</td>
            <td>
                <input type="text" name="s_name" placeholder="请输入姓名">
                <b style="color:red;">{{$errors->first('s_name')}}</b>
            </td>
        </tr>
        <tr>
            <td>性别</td>
            <td>
                <input type="radio" name="s_del" value="1" checked>男
                <input type="radio" name="s_del" value="2">女
                <b style="color:red;">{{$errors->first('s_del')}}</b>
            </td>
        </tr>
        <tr>
            <td>班级</td>
            <td>
                <select name="c_id">
                    @foreach($classinfo as $k=>$v)
                    <option value="{{$v->c_id}}">{{$v->c_name}}</option>
                        @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>成绩</td>
            <td><input type="text" name="s_cj">
                <b style="color:red;">{{$errors->first('s_cj')}}</b>
            </td>
        </tr>
        <tr>
            <td>头像</td>
            <td><input type="file" name="s_img"></td>
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
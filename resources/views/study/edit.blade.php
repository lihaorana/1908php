<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
<form action="{{url('/study/update/'.$info->s_id)}}" method="post"  enctype="multipart/form-data">
    <table border="1">
        @csrf
        <tr>
            <td>学生姓名</td>
            <td>
                <input type="text" name="s_name" value="{{$info->s_name}}" placeholder="请输入姓名">
                <b style="color:red;">{{$errors->first('s_name')}}</b>
            </td>
        </tr>
        <tr>
            <td>性别</td>
            <td>
                <input type="radio" name="s_del" value="1" @if($info->s_del==1) checked @endif >男
                <input type="radio" name="s_del" value="2" @if($info->s_del==2) checked @endif>女
                <b style="color:red;">{{$errors->first('s_del')}}</b>

            </td>
        </tr>
        <tr>
            <td>班级</td>
            <td>
                <select name="c_id">
                    @foreach($classinfo as $k=>$v)
                    <option value="{{$v->c_id}}" @if($info->c_id==$v->c_id)selected @endif>{{$v->c_name}}</option>
                        @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>成绩</td>
            <td><input type="text" name="s_cj" value="{{$info->s_cj}}">
                <b style="color:red;">{{$errors->first('s_cj')}}</b>

            </td>
        </tr>
        <tr>
            <td>头像</td>
            <td><input type="file" name="s_img">
                <img src="{{env('UPLOADS_URL')}}{{$info->s_img}}" height="50px" width="50px">
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
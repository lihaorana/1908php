<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<center><h2>表单编辑</h2></center>

<form  action="{{url('/people/update/'.$user->p_id)}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">名字</label>
        <div class="col-sm-10">
            <input type="text" name="username" value="{{$user->username}}" class="form-control" id="firstname" placeholder="请输入名字">
            <b style="color: red">{{$errors->first('username')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-10">
            <input type="text" name="age" value="{{$user->age}}" class="form-control" id="lastname" placeholder="请输入年龄">
            <b style="color: red">{{$errors->first('age')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">身份证</label>
        <div class="col-sm-10">
            <input type="text" name="card" value="{{$user->card}}" class="form-control" id="lastname" placeholder="请输入身份证号">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">头像</label>
        <div class="col-sm-10">
            <input type="file" name="head">
            <img src="{{env('UPLOADS_URL')}}{{$user->head}}" height="50px" width="50px">
        </div>
    </div>
    <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">是否是湖北人</label>
    <div class="radio">
        <label>
            <input type="radio" name="is_hubei" id="optionsRadios1" value="1"  @if($user->is_hubei==1)checked @endif>是
        </label>

        <label>
            <input type="radio" name="is_hubei" id="optionsRadios1" value="2"  @if($user->is_hubei==2)checked @endif>否
        </label>
    </div>
        </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">编辑</button>
        </div>
    </div>
</form>

</body>
</html>
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
<center><h2>表单列表展示</h2></center>
<form action="">
    <input type="text" name="username" value="{{$username}}" placeholder="请输入名字">
    <input type="submit" value="搜索">
</form>
<table class="table">
    <caption>上下文表格布局</caption>
    <thead>
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>年龄</th>
        <th>身份证</th>
        <th>头像</th>
        <th>添加时间</th>
        <th>是否是湖北人</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
        @foreach($data as $k=>$v)
    <tr @if($k%2==0) class="active" @else class="success" @endif>
        <td>{{$v->p_id}}</td>
        <td>{{$v->username}}</td>
        <td>{{$v->age}}</td>
        <td>{{$v->card}}</td>
        <td><img src="{{env('UPLOADS_URL')}}{{$v->head}}" height="50px" width="50px"></td>
        <td>{{date('y-m-d h:i:s',$v->add_time)}}</td>
        <td>{{$v->is_hubei==1?'√':'×'}}</td>
        <td><a href="{{url('people/edit/'.$v->p_id)}}" class="btn btn-info">修改</a> |
            <a href="{{url('people/destroy/'.$v->p_id)}}" class="btn btn-danger">删除</a></td>
    </tr>
    @endforeach
        <tr>
            <td colspan="7">{{$data->appends(['username'=>$username])->links()}}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
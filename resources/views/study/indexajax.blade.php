<table border="1">
    <tr>
        <td>id</td>
        <td>学生名称</td>
        <td>学生性别</td>
        <td>班级</td>
        <td>成绩</td>
        <td>头像</td>
        <td>操作</td>
    </tr>
    @foreach($info as $k=>$v)
        <tr>
            <td>{{$v->s_id}}</td>
            <td>{{$v->s_name}}</td>
            <td>{{$v->s_del==1?'男':'女'}}</td>
            <td>{{$v->c_name}}</td>
            <td><img src="{{env('UPLOADS_URL')}}{{$v->s_img}}" height="50px" width="50px"></td>
            <td>{{$v->s_cj}}</td>
            <td>
                <a href="{{url('/study/destroy/'.$v->s_id)}}">删除</a>
                <a href="{{url('/study/edit/'.$v->s_id)}}">修改</a>
            </td>
        </tr>
    @endforeach
</table>
{{$info->appends(['s_name'=>$s_name,'c_id'=>$c_id])->links()}}
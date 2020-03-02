<center>
    <form action="">
        名字: <input type="text" name="s_name" value="{{$s_name}}">
        班级:<select name="c_id">
            <option value="">-请选择-</option>
            @foreach($classinfo as $k=>$v)
                <option value="{{$v->c_id}}" @if($c_id==$v->c_id)selected @endif>{{$v->c_name}}</option>
            @endforeach
        </select>
        <input type="submit" value="搜索">
    </form>
</center>
<center class="ajax">
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
</center>
<script src="/static/js/jquery.js"></script>
<script >
//    pagination
    $(document).on('click','.pagination a',function(){
            var url=$(this).attr('href');
        if(!url){
            return
        }
        $.get(
                url,
                function(res){
                       $('.ajax').html(res);
                }
        )
        return false
    })
</script>
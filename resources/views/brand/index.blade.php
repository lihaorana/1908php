<table border="1">
    <tr>
        <td>id</td>
        <td>品牌名称</td>
        <td>品牌logo</td>
        <td>品牌网址</td>
        <td>品牌介绍</td>
        <td>操作</td>
    </tr>
    @foreach($info as $k=>$v)
    <tr>
        <td>{{$v->b_id}}</td>
        <td>{{$v->b_name}}</td>
        <td><img src="{{env('UPLOADS_URL')}}{{$v->b_logo}}" width="50px" height="50px"></td>
        <td>{{$v->b_url}}</td>
        <td>{{$v->b_account}}</td>
        <td>
            <a href="{{url('/brand/destroy/'.$v->b_id)}}">删除</a>
            <a href="{{url('/brand/edit/'.$v->b_id)}}">修改</a>
        </td>
    </tr>
        @endforeach
</table>
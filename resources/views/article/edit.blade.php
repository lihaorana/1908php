<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<form action="{{url('/article/update/'.$data->n_id)}}" method="post" enctype="multipart/form-data">
    <table border="1" n_id="{{$data->n_id}}">
        @csrf
        <tr>
            <td>文章标题</td>
            <td><input type="text" name="n_title" value="{{$data->n_title}}">
                <b style="color: red">{{$errors->first('n_title')}}</b>
            </td>
        </tr>
        <tr>
            <td>文章分类</td>
            <td><select name="a_id" id="">
                    @foreach($datas as $k=>$v)
                    <option value="{{$v->a_id}}" @if($data->a_id==$v->a_id)selected @endif>{{$v->a_name}}</option>
                        @endforeach
                </select></td>
        </tr>
        <tr>
            <td>文章重要性</td>
            <td>
                <input type="radio" name="is_zy" value="1" @if($data->is_zy==1)checked @endif>普通
                <input type="radio" name="is_zy" value="2" @if($data->is_zy==2)checked @endif>置顶
                <b style="color: red">{{$errors->first('is_zy')}}</b>
            </td>
        </tr>
        <tr>
            <td>是否显示</td>
            <td>
                <input type="radio" name="is_show" value="1"  @if($data->is_show==1)checked @endif>显示
                <input type="radio" name="is_show" value="2"  @if($data->is_show==2)checked  @endif>不显示
                <b style="color: red">{{$errors->first('is_show')}}</b>
            </td>
        </tr>
        <tr>
            <td>文章作者</td>
            <td><input type="text" name="n_man" value="{{$data->n_man}}">
                <b style="color: red">{{$errors->first('n_man')}}</b>
            </td>
        </tr>
        <tr>
            <td>作者email</td>
            <td><input type="text" name="n_email" value="{{$data->n_email}}"></td>
        </tr>
        <tr>
            <td>关键字</td>
            <td><input type="text" name="n_keyword" value="{{$data->n_keyword}}"></td>
        </tr>
        <tr>
            <td>网页描述</td>
            <td><textarea name="n_account" id="" cols="20" rows="6">{{$data->n_account}}</textarea></td>
        </tr>
        <tr>
            <td>上传文件</td>
            <td><input type="file" name="n_img">
                <img src="{{env('UPLOADS_URL')}}{{$data->n_img}}" height="50px" width="50px"></td>
        </tr>
        <tr>
            <td>
                <input type="button" value="修改">
                <input type="reset" value="重置">
            </td>
            <td></td>
        </tr>
    </table>
</form>
</body>
<script src="/static/js/jquery.min.js"></script>
<script>
    // ajax令牌
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $('input[name=n_title]').blur(function(){
        var _this=$(this)
        _this.next().html('');
        var n_title = _this.val();
        var n_id=_this.parents('table').attr('n_id');
        var reg = /^[\u4e00-\u9fa50-9A-Za-z_]+$/;
        if(!reg.test(n_title)){
            return  _this.next().text('文章标题由中文数字字母下划线组成且不为空');
        }
        $.ajax({
            url:"/article/uniqueness",
            data:{n_title:n_title,n_id:n_id},
            type:'post',
            async:false,
            dataType:'json',
            success:function(res){
//               return console.log(res);
                if(res.count>0){
                    _this.next().text(res.font);
                }else{
                    _this.next().html(res.font);
                }
            }
        });


    });

    $('input[name=n_man]').blur(function() {
        var _this=$(this)
        _this.next().html('');
        var n_man = _this.val();
        if(n_man==''){
            return  _this.next().text('文章标题必填');
        }
        var reg = /^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
        if(!reg.test(n_man)){
            return  _this.next().text('文章标题由中文数字字母下划线组成2-8位');
        }
    });
    {{--//表单移交--}}
    $('input[type=button]').click(function(){
        var n_titledata=true;
        var n_mandata=true;
        var n_title=  $('input[name=n_title]').val();
        var n_id=$('input[name=n_title]').parents('table').attr('n_id');
        var reg = /^[\u4e00-\u9fa50-9A-Za-z_]+$/;
        if(!reg.test(n_title)){
            n_titledata=false
            return     $('input[name=n_title]').next().html('文章标题由中文数字字母下划线组成且不为空');
        }
        $.ajax({
            url:"/article/uniqueness",
            data:{n_title:n_title,n_id:n_id},
            type:'post',
            async:false,
            dataType:'json',
            success:function(res){
//                console.log(res);
                if(res.count>0){
                    $('input[name=n_title]').next().text(res.font);
                    return    n_titledata=false
                }else{
                    return  $('input[name=n_title]').next().html(res.font);
                }
            }
        })
//       添加作者 alert(456)
//        $('input[name=n_man]').next().text('');
        var n_man = $('input[name=n_man]').val();
        if(n_man==''){
            return  $('input[name=n_man]').next().text('文章标题必填');
        }
        var reg = /^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
        if(!reg.test(n_man)){
            $('input[name=n_man]').next().text('文章标题由中文数字字母下划线组成2-8位');
            return  n_mandata=false
        }
        if (n_mandata&&n_titledata){
         return   $('form').submit()
        }else{
            alert('不可提交');
        }
//
    })
</script>
</html>
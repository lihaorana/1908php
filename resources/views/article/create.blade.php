<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<form action="{{url('/article/store')}}" method="post" enctype="multipart/form-data">
    <table border="1">
        @csrf
        <tr>
            <td>文章标题</td>
            <td><input type="text" name="n_title">
            <b style="color: red">{{$errors->first('n_title')}}</b>
            </td>
        </tr>
        <tr>
            <td>文章分类</td>
            <td><select name="a_id" id="">
                    @foreach($data as $k=>$v)
                        <option value="{{$v->a_id}}">{{$v->a_name}}</option>
                    @endforeach
                </select></td>
        </tr>
        <tr>
            <td>文章重要性</td>
            <td>
                <input type="radio" name="is_zy" value="1" checked >普通
                <input type="radio" name="is_zy" value="2">置顶
                <b style="color: red">{{$errors->first('is_zy')}}</b>
            </td>
        </tr>
        <tr>
            <td>是否显示</td>
            <td>
                <input type="radio" name="is_show" value="1"  checked >显示
                <input type="radio" name="is_show" value="2" >不显示
                <b style="color: red">{{$errors->first('is_show')}}</b>
            </td>
        </tr>
        <tr>
            <td>文章作者</td>
            <td><input type="text" name="n_man">
                <b style="color: red">{{$errors->first('n_man')}}</b>
            </td>
        </tr>
        <tr>
            <td>作者email</td>
            <td><input type="text" name="n_email"></td>
        </tr>
        <tr>
            <td>关键字</td>
            <td><input type="text" name="n_keyword"></td>
        </tr>
        <tr>
            <td>网页描述</td>
            <td><textarea name="n_account" id="" cols="20" rows="6"></textarea></td>
        </tr>
        <tr>
            <td>上传文件</td>
            <td><input type="file" name="n_img">

        </tr>
        <tr>
            <td>
                <input type="button" value="添加">
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
        var reg = /^[\u4e00-\u9fa50-9A-Za-z_]+$/;
        if(!reg.test(n_title)){
            return  _this.next().html('文章标题由中文数字字母下划线组成且不为空');
        }
        $.ajax({
            url:"uniqueness",
            data:{n_title:n_title},
            type:'post',
             async:true,
            dataType:'json',
            success:function(res){
//                console.log(res);
                if(res.count>0){
                    _this.next().html('文章标题已存在');
                }else{
                    _this.next().html('ok!');
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
    //表单移交
    $('input[type=button]').click(function(){
        var n_titledata=true;
        var n_mandata=true;
        var n_title=  $('input[name=n_title]').val();
        var reg = /^[\u4e00-\u9fa50-9A-Za-z_]+$/;
        if(!reg.test(n_title)){
            n_titledata=false
            return     $('input[name=n_title]').next().html('文章标题由中文数字字母下划线组成且不为空');
        }
        $.ajax({
            url:"uniqueness",
            data:{n_title:n_title},
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
        $('form').submit()
    }

    })
</script>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<center><h3>分类修改</h3></center>
<form class="form-horizontal" action="{{url('/cate/update/'.$info->cate_id)}}" method="post" role="form">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">分类名称</label>
        <div class="col-sm-3">
            <input type="text" name="cate_name" class="form-control" id="firstname"
                 value="{{$info->cate_name}}"  placeholder="请输入名称">
            <b style="color: red">{{$errors->first('cate_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">父分类</label>
        <div class="col-sm-2">
            <select name="p_id" id="" class="form-control">
                <option value="0">&nbsp;-请选中-</option>
                @foreach($data as $k=>$v)
                <option value="{{$v['cate_id']}}" @if($info->p_id==$v['cate_id']) selected @endif>{!! str_repeat('&nbsp;&nbsp;',$v['level']*3)!!}{{$v['cate_name']}}</option>
                    @endforeach
            </select>
            <b style="color: red">{{$errors->first('p_id')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">分类描述</label>
        <div class="col-sm-10">
            <textarea name="cate_account" id="" cols="20" rows="6">{{$info->cate_account}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="button" value="修改分类">
        </div>
    </div>
</form>

</body>
<script>
    // ajax令牌
var id={{$info->cate_id}}
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $('input[type=button]').click(function(){
        var cate_name=  $('input[name=cate_name]').val();
        if (cate_name==''){
            return   $('input[name=cate_name]').next().text('js分类名称必填');
        }
        var reg=/^[\u4e00-\u9fa5A-Za-z0-9_]+$/
        if(!reg.test(cate_name)){
            return   $('input[name=cate_name]').next().text('js分类名称是中文数字字母下划线');
        }
        var res=ajaxtest($('input[name=cate_name]'),cate_name,id);
        if (res===1){
            return  $('input[name=cate_name]').next().text('js已存在');
        }else{
            $('input[name=cate_name]').next().text('ok');
        }
        $('form').submit()
    })
    $('input[name=cate_name]').blur(function(){
        var _this=$(this)
        var cate_name= _this.val();
        if (cate_name==''){
            return  _this.next().text('js分类名称必填');
        }
        var reg=/^[\u4e00-\u9fa5A-Za-z0-9_]+$/
        if(!reg.test(cate_name)){
            return  _this.next().text('js分类名称是中文数字字母下划线');
        }
       var res= ajaxtest(_this,cate_name,id);
        if (res===1){
            _this.next().text('js已存在');
        }else{
            _this.next().text('ok');
        }
    });
    function ajaxtest(_this,value,id){
        $.ajax({
            url:'/cate/ajaxtest',
            type:'post',
            data:{value:value,id:id},
            async:false,
            dataType:'json',
            success:function(res){
                if (res.count>0){
                    aa= 1;
                }else{
                    aa= 2;
                }
            }
        });
        return aa
    }
</script>
</html>
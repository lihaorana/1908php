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
<center><h3>商品添加</h3></center>
<form class="form-horizontal" action="{{url('shop/store')}}" method="post" role="form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">商品名称</label>
        <div class="col-sm-3">
            <input type="text" name="shop_name" class="form-control" id="firstname"
                   placeholder="请输入名称">
            <b style="color: red">{{$errors->first('shop_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">商品价格</label>
        <div class="col-sm-3">
            <input type="text" name="shop_price" class="form-control" id="firstname"
                   placeholder="请输入价格">
            <b style="color: red">{{$errors->first('shop_price')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">商品缩略图</label>
        <div class="col-sm-3">
            <input type="file" name="shop_img"  id="firstname">
            <b style="color: red">{{$errors->first('shop_img')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">商品库存</label>
        <div class="col-sm-3">
            <input type="text" name="shop_num" class="form-control" id="firstname"
                   placeholder="请输入库存">
            <b style="color: red">{{$errors->first('shop_num')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">是否精品</label>
        <div class="col-sm-3">
            <input type="radio" name="is_cp"  value="1" checked id="firstname">是
            <input type="radio" name="is_cp"  value="2" id="firstname">否
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">是否热卖</label>
        <div class="col-sm-3">
            <input type="radio" name="is_new"  value="1" checked id="firstname">是
            <input type="radio" name="is_new"  value="2" id="firstname">否
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">是否首页展示</label>
        <div class="col-sm-3">
            <input type="radio" name="shop_show"  value="1" checked id="firstname">是
            <input type="radio" name="shop_show"  value="2" id="firstname">否
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">分类</label>
        <div class="col-sm-2">
            <select name="cate_id" id="" class="form-control">
                <option value="">&nbsp;-请选中-</option>
                @foreach($cateinfo as $k=>$v)
                <option value="{{$v['cate_id']}}">{!! str_repeat('&nbsp;&nbsp;',$v['level']*3)!!}{{$v['cate_name']}}</option>
                    @endforeach
            </select>
            <b style="color: red">{{$errors->first('cate_id')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">品牌</label>
        <div class="col-sm-2">
            <select name="b_id" id="" class="form-control">
                <option value="">&nbsp;-请选中-</option>
                @foreach($brandinfo as $k=>$v)
                    <option value="{{$v->b_id}}">{{$v->b_name}}</option>
                @endforeach
            </select>
            <b style="color: red">{{$errors->first('b_id')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品详情</label>
        <div class="col-sm-10">
            <textarea name="shop_account" id="" cols="20" rows="6"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品相册</label>
        <div class="col-sm-10">
            <input type="file" name="shop_file[]" multiple>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
             <input type="button" value="添加商品">
        </div>
    </div>
</form>

</body>
<script>
    // ajax令牌
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $('input[type=button]').click(function(){
        var shop_name=  $('input[name=shop_name]').val();
        if (shop_name==''){
            return   $('input[name=shop_name]').next().text('js分类名称必填');
        }
        var reg=/^[\u4e00-\u9fa5A-Za-z0-9_]+$/
        if(!reg.test(shop_name)){
            return   $('input[name=shop_name]').next().text('js分类名称是中文数字字母下划线');
        }
         var res=ajaxtest($('input[name=shop_name]'),shop_name);
            if (res===1){
              return  $('input[name=shop_name]').next().text('js已存在');
            }else{
              $('input[name=shop_name]').next().text('ok');
            }
        /**商品价格*/
                var shop_price= $('input[name=shop_price]').val();
                if (shop_price==''){
                    return  $('input[name=shop_price]').next().text('js商品价格必填');
                }
                var reg=/^\d+$/
                if(!reg.test(shop_price)){
                    return $('input[name=shop_price]').next().text('js商品价格是数字');
                }
        /**库存*/
        var shop_num=  $('input[name=shop_num]').val();
        if (shop_num==''){
            return   $('input[name=shop_num]').next().text('js商品库存必填');
        }
        var reg1=/^\d+$/
        if(!reg1.test(shop_num)){
            return   $('input[name=shop_num]').next().text('js商品库存是数字');
        }
      $('form').submit()

    })
    /**商品价格*/
    $('input[name=shop_price]').blur(function(){

            var _this=$(this)
        _this.next().text('')
            var shop_price= _this.val();
    if (shop_price==''){
        return  _this.next().text('js商品价格必填');
    }
    var reg=/^\d+$/
    if(!reg.test(shop_price)){
        return  _this.next().text('js商品价格是数字');
    }
    })
    /**商品c库存*/
    $('input[name=shop_num]').blur(function(){
        var _this=$(this)
        _this.next().text('')
        var shop_num= _this.val();
        if (shop_num==''){
            return  _this.next().text('js商品库存必填');
        }
        var reg=/^\d+$/
        if(!reg.test(shop_num)){
            return  _this.next().text('js商品库存是数字');
        }
    })
    $('input[name=shop_name]').blur(function(){
                var _this=$(this)
        _this.next().text('')
        var shop_name= _this.val();
            if (shop_name==''){
              return  _this.next().text('js商品名称必填');
            }
            var reg=/^[\u4e00-\u9fa5A-Za-z0-9_]+$/
            if(!reg.test(shop_name)){
                return  _this.next().text('js商品名称是中文数字字母下划线');
            }
         var res=ajaxtest(_this,shop_name);
           if (res===1){
             return  _this.next().text('js已存在');
           }else{
             return  _this.next().text('ok');
           }
        });
    function ajaxtest(_this,value){
        var aa=1;
        $.ajax({
            url:'/shop/ajaxtest',
            type:'post',
            data:{value:value},
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
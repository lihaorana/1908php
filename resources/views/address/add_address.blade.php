@extends('layouts.shop')
@section('title', '添加收货地址页')
@section('content')
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/static/index/images/head.jpg" />
    </div><!--head-top/-->
                   <b style="color: red">{{session('user_msg')}}</b>
    <form action="{{url('address_do')}}" method="post" class="reg-login">
        @csrf
        <div class="lrBox">
            <div class="lrList">
                <input type="text" name="add_name" placeholder="收货人" />
                <b style="color: red">{{$errors->first('add_name')}}</b>
            </div>
            <div class="lrList">
                <select class="site" name="province">
                    <option value="">省份/直辖市</option>
                    @foreach($areainfo as $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                        @endforeach
                </select>
                <b style="color: red">{{$errors->first('province')}}</b>
            </div>
            <div class="lrList">
                <select class="site" name="city">
                    <option value="">市/区</option>
                </select>
                <b style="color: red">{{$errors->first('city')}}</b>
            </div>
            <div class="lrList">
                <select class="site" name="area">
                    <option value="">县</option>
                </select>
            </div>
            <div class="lrList">
                <input type="text" name="add_detailed" placeholder="详细地址" />
            </div>
            <div class="lrList">
                <input type="text" name="tel" placeholder="手机" />
                <b style="color: red">{{$errors->first('tel')}}</b>
            </div>
            <div><input type="radio" name="is_default" value="1"/> <div>设为默认</div></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" value="保存" />
        </div>
    </form><!--reg-login/-->
    <script src="/static/js/jquery.js"></script>
    <script>
        //内容改变值三级联动
        $(document).on('change','.site',function(){
            var _this =$(this)
              var id=_this.val();
            if (id==0){
                _this.parent().next().find('select').html('<option value="" selected="selected">请选择...</option>')
                return false;
            }
            $.get(
                    "{{'/address/site'}}",
                    {id:id},
                    function(res){
//                 return   console.log(res)
                        var _option="<option value='0' selected>-请选择-</option>"
                        for(var i in res){
                            _option+= "<option value="+res[i]['id']+">"+res[i]['name']+"</option>"
                       }
//                                         return   console.log(_option)
                        _this.parent().next().find('select').html(_option);
                    },'json'
            )
        })
    </script>
@endsection
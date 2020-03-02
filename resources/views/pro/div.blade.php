@foreach($shopinfo as $v)
    <dl>
        <dt><a href="{{url('/proinfo/'.$v->shop_id)}}"><img src="{{env('UPLOADS_URL')}}{{$v->shop_img}}" width="100" height="100" /></a></dt>
        <dd>
            <h3><a href="{{url('/proinfo/'.$v->shop_id)}}">{{$v->shop_name}}</a></h3>
            <div class="prolist-price"><strong>¥ {{$v->shop_price}}</div>
            <div class="prolist-yishou"> <em>已售：35</em></div>
        </dd>
        <div class="clearfix"></div>
    </dl>
@endforeach
{{$shopinfo->appends(['shop_name'=>$shop_name])->links()}}

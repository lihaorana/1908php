<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\Brand;
use App\Cate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ProController extends Controller
{
    public function prolist($id=''){
//        $b_id=request()->b_id;
        $where=[];
        if($id){
            $where[]=['b_id','=',$id];
        }
        $shop_name=request()->shop_name??'';
        if($shop_name){
            $where[]=['shop_name','like','%'.$shop_name.'%'];
        }
        $ShopListPag=config('app.ShopListPag');
        $page=request()->page??"";
//        $shopinfo=cache('shopinfo'.$id.'_'.$shop_name.'_'.$page);
//        Cache::flush();

       $shopinfo= Redis::get('shopinfo'.$id.'_'.$shop_name.'_'.$page);
//        dump($shopinfo);

        if(!$shopinfo){
            echo 'DB';
            $shopinfo = Shop::where($where)->paginate($ShopListPag);
//            cache(['shopinfo'.$id.'_'.$shop_name.'_'.$page=>$shopinfo],60*60*24);
            $shopinfo=serialize($shopinfo);
            Redis::setex('shopinfo'.$id.'_'.$shop_name.'_'.$page,60*60,$shopinfo);
        }
        $shopinfo=unserialize($shopinfo);
        if(request()->ajax()){
            return view('pro.div',['shopinfo'=>$shopinfo,'shop_name'=>$shop_name]);
        }
        return view('pro.prolist',['shopinfo'=>$shopinfo,'shop_name'=>$shop_name]);
    }

    public function proinfo($id){
//        $shopinfo=cache('proinfo'.$id);
//        dump($shopinfo);
            $shopinfo=Redis::get('proinfo'.'_'.$id);
//                dump($shopinfo);
        if(!$shopinfo){
            $shopinfo = Shop::where(['shop_id' => $id])->first();
//            cache(['proinfo'.$id=>$shopinfo],60*60*24);
            $shopinfo=serialize($shopinfo);
            Redis::set('proinfo'.'_'.$id,$shopinfo);
        }
        $shopinfo=unserialize($shopinfo);
      $num=  Redis::setnx('num'.$id,0);
        if(!$num){
            $num= Redis::incr('num'.$id);
        }
        return view('pro.proinfo',['shopinfo'=>$shopinfo,'num'=>$num]);
    }

    public function getshop(){
       $field= request()->value;
        $where=[];
        $shop_name=request()->shop_name??'';
        if($shop_name){
            $where[]=['shop_name','like','%'.$shop_name.'%'];
        }
        $ShopListPag=config('app.ShopListPag');
        if($field=='is_new'){
            $where[]=['is_new','=',1];
            $res=Shop::where($where)->orderby('add_time','desc')->paginate($ShopListPag);
        }
        if($field=='shop_price'){
            $res=Shop::where($where)->orderby('shop_price','desc')->paginate($ShopListPag);
        }

        if($res){
            return view('pro.div',['shopinfo'=>$res,'shop_name'=>$shop_name]);
        }

    }
}

<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Brand;
use App\Shop;
use Illuminate\Support\Facades\Cache;
class IndexController extends Controller
{
    public function index(){

        $shop_name=request()->shop_name??"";
        $where=[];
        if($shop_name){
            $where[]=['shop_name','like','%'.$shop_name.'%'];
        }
        $brandinfo=Cache::get('brandinfo_');
//        dump($brandinfo);
        if(!$brandinfo){
            $brandinfo=Brand::limit(8)->get();
            Cache::put('brandinfo_',$brandinfo,60*60*24);
        }
                $shopinfo=Cache::get('shopinfo_'.$shop_name);
//                Cache::delete('');
//        dump($shopinfo);
            if(!$shopinfo){
                $shopinfo=Shop::where($where)->limit(10)->get();
                Cache::put('shopinfo_'.$shop_name,$shopinfo,60*60*24);
            }

    return  view('index.index',['brandinfo'=>$brandinfo,'shopinfo'=>$shopinfo,'shop_name'=>$shop_name]);
    }

}

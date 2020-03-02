<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop;
use App\IndexModel\Cart;
class CartController extends Controller
{
    public function cart(){
        $u_id=session('user.u_id');
        $where=[
            ['u_id','=',$u_id],
            ['cart_del','=',1]
        ];

        $cartinfo=Cart::leftjoin('shop','cart.shop_id','=','shop.shop_id')->where($where)->get();
        $count=Cart::leftjoin('shop','cart.shop_id','=','shop.shop_id')->where($where)->count();

//        dd($cartinfo);
        return view('cart.cart',['cartinfo'=>$cartinfo,'count'=>$count]);
    }

    /**添加购物车*/
    public function addcart(){
        $shop_id=request()->shop_id;
        $num=request()->num;
       $u_id= session('user.u_id');
        if(empty($u_id)){
        return json_encode(['code'=>2,'msg'=>'您还没有登录那,请登录！']);
        }
        //验证添加是否纯在
        $where=[
            ['shop_id','=',$shop_id],
            ['u_id','=',$u_id],
            ['cart_del','=',1]
        ];
            $cartinfo=Cart::where($where)->first();
            if($cartinfo){
            $data=['cart_num'=>$cartinfo['cart_num']+$num,'cart_time'=>time()];
                $res=Cart::where(['cart_id'=>$cartinfo['cart_id']])->update($data);
            }else{
                $data=['shop_id'=>$shop_id,'cart_num'=>$num,'u_id'=>$u_id,'cart_time'=>time()];
                $res=Cart::create($data);
            }
                $shopinfo=Shop::find($shop_id);

            Shop::where(['shop_id'=>$shop_id])->update(['shop_num'=>$shopinfo['shop_num']-$num]);
        if($res){
            return  json_encode(['code'=>1,'msg'=>'添加购物车成功']);
        }else{
            return  json_encode(['code'=>2,'msg'=>'添加购物车失败']);
        }
    }

/**cart--修改购买数量*/
    public function upd_cart_num(){
        $shop_id=request()->shop_id;
          $cart_num=request()->cart_num;
        if(empty($shop_id)||empty($cart_num)){
            return JsonError('操作有误');
        }
        $u_id=session('user.u_id');
        if(empty($u_id)){
            return JsonError('您要去登录呀');
        }
        $where=[
            ['shop_id','=',$shop_id],
            ['u_id','=',$u_id],
            ['cart_del','=',1]
        ];
            $res=Cart::where($where)->update(['cart_num'=>$cart_num]);
        if($res!==false){
            return JsonSuccess();
        }else{
            return JsonError('数量操作有误');
        }
    }

    /**cart--获取小计*/
    public function getnewtotal(){
        $shop_id=request()->shop_id;
        $u_id=session('user.u_id');
        if(empty($u_id)){
            return JsonError('您要去登录呀');
        }
        $where=[
            ['cart.shop_id','=',$shop_id],
            ['u_id','=',$u_id],
            ['cart_del','=',1]
        ];
        $info=Cart::leftjoin('shop','cart.shop_id','=','shop.shop_id')->where($where)->first();

        if(!empty($info)){
           $price= (int)$info['shop_price']*$info['cart_num'];
            return JsonSuccess($price);
        }else{
            return JsonError('操作有误');
        }
    }

    /**删除*/
    public function del()
    {
        $shop_id = request()->shop_id;
        if(empty($shop_id)){
            return JsonError('非法操作删除');
        }
        $u_id = session('user.u_id');
        if (empty($u_id)) {
            return JsonError('您要去登录呀');
        }
        $shop_id = explode(',', $shop_id);
//        print_r($shop_id);die;


        foreach ($shop_id as $v){
            $where = [
                ['shop_id', '=', $v],
                ['u_id', '=', $u_id],
                ['cart_del', '=', 1]
            ];
            $res = Cart::where($where)->update(['cart_del'=>2]);
    }
        if($res){
            return JsonSuccess();
        }else{
            return JsonError('删除失败');
        }
    }

//    获取总价
    public function getmoery(){
        $shop_id = request()->shop_id;
        if(empty($shop_id)){
            return JsonError('非法操作获取总价');
        }
        $u_id = session('user.u_id');
        if (empty($u_id)) {
            return JsonError('您要去登录呀');
        }
        $shop_id = explode(',', $shop_id);
         $moery=0;
//        echo $moery;die;
        foreach ($shop_id as $v){
            $where = [
                ['cart.shop_id', '=',$v],
                ['u_id', '=', $u_id],
                ['cart_del', '=', 1]
            ];
            $info=Cart::leftjoin('shop','cart.shop_id','=','shop.shop_id')->where($where)->first();
              $moery= $moery+($info['shop_price']*$info['cart_num']);
        }
        if($moery){
            return JsonSuccess($moery);
        }
    }
}

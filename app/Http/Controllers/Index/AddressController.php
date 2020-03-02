<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IndexModel\Address;
use Illuminate\Support\Facades\Cookie;
use App\IndexModel\Area;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function is_address(){
//        $user=request()->user;
        $user=session('user.u_id');
        if(!$user){
            return JsonError('请登录后操作！');
        }
            $addinfo=Address::where(['u_id'=>$user])->count();
        if($addinfo<=0){
                return json_encode(['code'=>3,'msg'=>'请去新添一个收货地址吧']);
        }
        return JsonSuccess('ok');
    }

    public function add_address($id=''){
//        echo "addree";die;
        if(!empty($id)){
            Cookie::queue('goods_ids',$id,200);
        }
        $areainfo=Area::where(['pid'=>0])->get();
        return view('address.add_address',['areainfo'=>$areainfo]);
    }
    public function address_do(){
        $data=request()->except('_token');
//        $goods_id=Cookie::get('goods_ids');
//        dd($goods_id);
        $user=session('user.u_id');
        if(!$user){
            return redirect('/add_address')->with('user_msg','登录超时啦，请登录!');
        }
        $data['u_id']=$user;
        $validator=Validator::make($data,[
            'add_name'=>['required','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'province'=>'required',
            'city'=>'required',
            'tel'=>'required',
        ],[
            'add_name.required'=>'商品名称必填',
            'add_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'province.required'=>'省份必填',
            'city.required'=>'市/区必填',
            'tel.required'=>'手机必填',
        ]);

        if ($validator->fails())
        {
            return redirect('/add_address')
                ->withErrors($validator)
                ->withInput();
        }
        $res=Address::create($data);
        if($res){
         $goods_id=Cookie::get('goods_ids');
            if($goods_id){
            return redirect('/order/3');
            }else{

            }
        }
    }

    /**三级联动*/
    public function site(){
        $id=request()->id;
//        echo $id;die;
        $areainfo=Area::where(['pid'=>$id])->get();
        return json_encode($areainfo);
    }
}

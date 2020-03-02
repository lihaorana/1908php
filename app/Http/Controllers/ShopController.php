<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Cate;
use App\Brand;
use App\Shop;
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $b_id=request()->b_id;
        $where=[];
        if($b_id){
            $where[]=['shop.b_id','=',$b_id];
        }
        $cate_id=request()->cate_id;
        if($cate_id){
            $where[]=['shop.cate_id','=',$cate_id];
        }
        $shop_name=request()->shop_name;
        if($shop_name){
            $where[]=['shop_name','like','%'.$shop_name.'%'];
        }
//        $cateinfo=Cate::where(['cate_id','=',$cate_id])->find();

        /**分类数据*/
        $cateinfo=Cate::all()->toArray();
        $cateinfo= cateinfo($cateinfo);
        /**品牌数据*/
        $pag=config('app.pageSize');
        $brandinfo=Brand::all();
        $info=Shop::leftjoin('cate','cate.cate_id','=','shop.cate_id')
            ->leftjoin('brand','brand.b_id','=','shop.b_id')
            ->where($where)
            ->paginate($pag);

//        dump($info);die;
       return view('shop/index',['info'=>$info,'cateinfo'=>$cateinfo,'brandinfo'=>$brandinfo,
           'b_id'=>$b_id,'cate_id'=>$cate_id,'shop_name'=>$shop_name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**分类数据*/
        $cateinfo=Cate::all()->toArray();
       $cateinfo= cateinfo($cateinfo);
        /**品牌数据*/
        $brandinfo=Brand::all();
        return  view('shop.create',['cateinfo'=>$cateinfo,'brandinfo'=>$brandinfo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token');
        $validator=Validator::make($data,[
            'shop_name'=>['required','unique:shop','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'shop_num'=>'required|regex:/^\d+$/',
            'shop_price'=>'required|regex:/^\d+$/',
            'cate_id'=>'required',
            'b_id'=>'required',
        ],[
            'shop_name.required'=>'商品名称必填',
            'shop_name.unique'=>'名称已存在',
            'shop_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'shop_num.required'=>'商品库存必填',
            'shop_num.regex'=>'商品库存必须是数字',
            'shop_price.required'=>'商品价格必填',
            'shop_price.regex'=>'商品价格必需是数字',
            'cate_id.required'=>'商品分类必填',
            'b_id.required'=>'商品品牌必填',
        ]);

        if ($validator->fails())
        {
            return redirect('shop/create')
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('shop_img')){
            $data['shop_img']=upload('shop_img');
        };
        if($request->hasFile('shop_file')){
            $data['shop_file']=MoreUploads('shop_file');
        };
//        print_r($shop_file);die;
        $user_id=session('adminlogin.admin_id');
//        echo $user_id;die;
        $data['shop_art']=time().rand(00000,99999).$user_id;
        $data['add_time']=time();
        $res=Shop::create($data);
       if($res){
           return redirect('shop');
       }else{
           return redirect('shop/create');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shopinfo=Shop::find($id);
        /**分类数据*/
        $cateinfo=Cate::all()->toArray();
        $cateinfo= cateinfo($cateinfo);
        /**品牌数据*/
        $brandinfo=Brand::all();
        return view('shop/edit',['cateinfo'=>$cateinfo,'shopinfo'=>$shopinfo,'brandinfo'=>$brandinfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except('_token');
        $validator=Validator::make($data,[
            'shop_name'=>['required',Rule::unique('shop')->ignore($request->id,'shop_id'),
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'shop_num'=>'required|regex:/^\d+$/',
            'shop_price'=>'required|regex:/^[0-9\.]+$/',
            'cate_id'=>'required',
            'b_id'=>'required',
        ],[
            'shop_name.required'=>'商品名称必填',
            'shop_name.unique'=>'名称已存在',
            'shop_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'shop_num.required'=>'商品库存必填',
            'shop_num.regex'=>'商品库存必须是数字',
            'shop_price.required'=>'商品价格必填',
            'shop_price.regex'=>'商品价格必需是数字',
            'cate_id.required'=>'商品分类必填',
            'b_id.required'=>'商品品牌必填',
        ]);

        if ($validator->fails())
        {
            return redirect('shop/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('shop_img')){
            $data['shop_img']=upload('shop_img');
        };
        if($request->hasFile('shop_file')){
            $data['shop_file']=MoreUploads('shop_file');
        };
//        print_r($shop_file);die;
        $user_id=session('adminlogin.admin_id');
//        echo $user_id;die;
        $data['shop_art']=time().rand(00000,99999).$user_id;
        $data['add_time']=time();
        $res=Shop::where(['shop_id'=>$id])->update($data);
        if($res!==false){
            return redirect('shop');
        }else{
            return redirect('shop/edit/'.$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Shop::destroy($id);
        if($res){
            echo json_encode(['code'=>00000,'msg'=>'成功']);
        }else{
            echo json_encode(['code'=>11111,'msg'=>'失败']);
        }
    }
    public function ajaxtest(){
        $value=request()->value;
        $where=[
            ['shop_name','=',$value]
        ];
        $shop_id=request()->id;
        if($shop_id){
            $where[]=['shop_id','!==',$shop_id];
        }
        $count=Shop::where($where)->count();
        if($count>0){
            echo json_encode(['code' => 00000, 'msg' => '该名称已存在', 'count' => $count]);die;
        }
        echo json_encode(['code' =>11111, 'msg' => 'ok', 'count' => $count]);die;
    }
}

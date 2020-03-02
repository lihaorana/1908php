<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info=Cate::all()->toArray();
        $info=  cateinfo($info);
        return view('cate/index',['info'=>$info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info=Cate::all()->toArray();
//        print_r($info);die;
        $data=  cateinfo($info);
//        print_r($data);die;
        return view('cate.create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $data=  $request->except('_token');
        $validator=Validator::make($data,[
            'cate_name'=>['required','unique:cate','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'p_id'=>'required',
        ],[
            'cate_name.required'=>'分类名称必填',
            'cate_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'cate_name.unique'=>'分类已存在',
            'p_id.required'=>'父分类必填',

        ]);
        if ($validator->fails())
        {
            return redirect('cate/create')
                ->withErrors($validator)
                ->withInput();
        }
    $res=Cate::create($data);
        if($res){
            return redirect('cate');
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
        $info=Cate::all()->toArray();
        $data=  cateinfo($info);
        $info=Cate::find($id);

        return view('cate.edit',['info'=>$info,'data'=>$data]);
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
      $data= $request->except('_token');
        $validator=Validator::make($data,[
            'cate_name'=>['required', Rule::unique('cate')->ignore($id,'cate_id'),'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'p_id'=>'required',
        ],[
            'cate_name.required'=>'分类名称必填',
            'cate_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'cate_name.unique'=>'分类已存在',
            'p_id.required'=>'父分类必填',

        ]);
        if ($validator->fails())
        {
            return redirect('cate/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        $res=Cate::where(['cate_id'=>$id])->update($data);
        if($res!==false){
            return redirect('cate');
        }else{
            return redirect('cate/edit/'.$id);
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
        $where=[
            ['p_id','=',$id]
        ];
        $pinfo=Cate::where($where)->count();
        if($pinfo){
           echo json_encode(['code'=>2,'msg'=>'此分类下有数据不可删除']);
        }else{
            Cate::destroy($id);
            echo json_encode(['code'=>1,'msg'=>'已删除']);
        }
    }
    public function ajaxtest(){
        $value=request()->value;
        $where=[
            ['cate_name','=',$value]
        ];
        $cate_id=request()->id;
        if($cate_id){
            $where[]=['cate_id','!=',$cate_id];
        }
        $count=Cate::where($where)->count();
        if($count>0){
            echo json_encode(['code' => 00000, 'msg' => '该名称已存在', 'count' => $count]);die;
        }
        echo json_encode(['code' =>11111, 'msg' => 'ok', 'count' => $count]);die;
    }
}

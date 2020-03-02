<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           $info= Admin::all();
        return view('admin/index',['info'=>$info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data= $request->except('_token');
        $validator=Validator::make($data,[
            'admin_name'=>['required','unique:admin','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'admin_pwd'=>'required',
            'admin_pwd2'=>'required',
        ],[
            'admin_name.required'=>'账号必填',
            'admin_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'admin_name.unique'=>'账号已存在',
            'admin_pwd.required'=>'密码必填',
            'admin_pwd2.required'=>'确认密码必填',

        ]);
        if ($validator->fails())
        {
            return redirect('admin/create')
                ->withErrors($validator)
                ->withInput();
        }
        if($data['admin_pwd']!==$data['admin_pwd2']){
            return redirect('admin/create');die;
        }
     unset($data['admin_pwd2']);
            $data['admin_pwd']= encrypt($data['admin_pwd']);
        if($request->hasFile('admin_img')){
            $data['admin_img']=upload('admin_img');
        };
        $res=Admin::create($data);
        if($res){
        return redirect('admin');
        }else{
            return redirect('admin/create');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info=Admin::find($id);
        $info['admin_pwd']=decrypt($info['admin_pwd']);
        return view('admin/edit',['info'=>$info]);
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
            'admin_name'=>['required',Rule::unique('admin')->ignore($id,'admin_id'),'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'admin_pwd'=>'required',
            'admin_pwd2'=>'required',
        ],[
            'admin_name.required'=>'账号必填',
            'admin_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'admin_name.unique'=>'账号已存在',
            'admin_pwd.required'=>'密码必填',
            'admin_pwd2.required'=>'确认密码必填',

        ]);
        if ($validator->fails())
        {
            return redirect('admin/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        if($data['admin_pwd']!==$data['admin_pwd2']){
            return redirect('admin/edit/'.$id);
        }
        unset($data['admin_pwd2']);
        $data['admin_pwd']= encrypt($data['admin_pwd']);
        if($request->hasFile('admin_img')){
            $data['admin_img']=upload('admin_img');
        };
        $res=Admin::where(['admin_id'=>$id])->update($data);
        if($res!==false){
            return redirect('admin');
        }else{
            return redirect('admin/edit/'.$id);
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
        $res=Admin::destroy($id);
        if($res){
            return redirect('admin');
        }else{
            return redirect('admin');
        }
    }
}

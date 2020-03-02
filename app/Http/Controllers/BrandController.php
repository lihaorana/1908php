<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info=Brand::all();
        return view('/brand/index',['info'=>$info]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
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
            'b_name'=>['required','unique:brand','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'b_url'=>'required|regex:/^[A-Za-z0-9\.]+$/',
        ],[
            'b_name.required'=>'品牌名称必填',
            'b_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'b_name.unique'=>'品牌已存在',
            'b_url.required'=>'品牌网址必填',
            'b_url.regex'=>'品牌网址不能用中文和特殊字符',
        ]);
        if ($validator->fails())
        {
            return redirect('brand/create')
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('b_logo')){
            $data['b_logo']=upload('b_logo');
        };
        $res=Brand::create($data);
//        dd($res);
        if($res){
            return redirect('/brand');
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
        $data=Brand::find($id);
        return view('/brand/edit',['data'=>$data]);
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
            'b_name'=>['required',Rule::unique('brand')->ignore($id,'b_id'),'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'b_url'=>'required|regex:/^[A-Za-z0-9\.]+$/',
        ],[
            'b_name.required'=>'品牌名称必填',
            'b_name.regex'=>'必须是中文,字母，下划线，数字组成',
            'b_name.unique'=>'品牌已存在',
            'b_url.required'=>'品牌网址必填',
            'b_url.regex'=>'品牌网址不能用中文和特殊字符',
        ]);
        if ($validator->fails())
        {
            return redirect('brand/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('b_logo')){
            $data['b_logo']=upload('b_logo');
        }
        $res=Brand::where('b_id',$id)->update($data);
        if($res!==false){
        return redirect('/brand');
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
        $res=Brand::destroy($id);
        if($res){
            return redirect('/brand');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s_name=request()->s_name??'';
        $c_id=request()->c_id??'';
        $where=[];
        if($s_name){
            $where[]=['s_name','like','%'.$s_name.'%'];
        }
        if($c_id){
            $where[]=['study.c_id','=',$c_id];
        }
            $classinfo=cache('classinfo');
                if(!$classinfo) {//
                    $classinfo = DB::table('class')->get();
                    cache(['classinfo'=>$classinfo],60*60*5);
                }
        $pag=request()->page;
        $info=cache('info_'.$s_name.'_'.$c_id.'_'.$pag);
//                Cache::flush();
//        var_dump($info);
        $pages=config('app.pageSize');
        if(!$info){
            echo 'Db';
            $info=DB::table('study')->join('class','study.c_id','=','class.c_id')->where($where)->paginate($pages);
            cache(['info_'.$s_name.'_'.$c_id.'_'.$pag=>$info],60*60*5);
        }
//        dump(request()->ajax());
        if(request()->ajax()){
            return view('/study/indexajax',['info'=>$info,'classinfo'=>$classinfo,'s_name'=>$s_name,'c_id'=>$c_id]);
        }
        return view('/study/index',['info'=>$info,'classinfo'=>$classinfo,'s_name'=>$s_name,'c_id'=>$c_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $classinfo= DB::table('class')->get();
//        dd($classinfo);
        return view('study.create',['classinfo'=>$classinfo]);
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
            's_name'=>['required','unique:study','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,12}$/u'],
            's_del'=>'required|numeric',
            's_cj'=>'required|numeric|between:0,100',
        ],[
            's_name.required'=>'名称必填',
            's_name.unique'=>'名称已存在',
            's_name.regex'=>'必须是中文,字母，下划线，数字组成且2,12位',
            's_del.required'=>'性别必填',
            's_del.numeric'=>'必须是数值',
            's_cj.required'=>'成绩必填',
            's_cj.numeric'=>'必须是数值',
            's_cj.between'=>'不能超过100',
        ]);
        if ($validator->fails())
        {
            return redirect('study')
                ->withErrors($validator)
                ->withInput();
        }

        if($request->hasFile('s_img')){
            $data['s_img']=upload('s_img');
        }
        $res=DB::table('study')->insert($data);
        if($res){
            return redirect('/study/index');
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
        $classinfo= DB::table('class')->get();
        $info=DB::table('study')->where('s_id',$id)->first();
       return view('/study/edit',['classinfo'=>$classinfo,'info'=>$info]);
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
            's_name'=>['required',Rule::unique('study')->ignore($request->id,'s_id'),'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,12}$/u'],
            's_del'=>'required|numeric',
            's_cj'=>'required|numeric|between:0,100',
        ],[
            's_name.required'=>'名称必填',
            's_name.unique'=>'名称已存在',
            's_name.regex'=>'必须是中文,字母，下划线，数字组成且2,12位',
            's_del.required'=>'性别必填',
            's_del.numeric'=>'必须是数值',
            's_cj.required'=>'成绩必填',
            's_cj.numeric'=>'必须是数值',
            's_cj.between'=>'不能超过100',
        ]);
        if ($validator->fails())
        {
            return redirect("study/edit/".$id)
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('s_img')){
        $data['s_img']=upload('s_img');
        }

        $res=DB::table('study')->where('s_id',$id)->update($data);
        if($res!==false){
         return redirect('/study/index');
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
        $res=DB::table('study')->where('s_id',$id)->delete();
        if($res){
            return redirect('/study/index');
        }
    }
}

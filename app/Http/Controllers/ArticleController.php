<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\DB;
//use app\Brand;
use Illuminate\Support\Facades\Validator;
use App\News;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        session(['admin'=>'123']);
//        $res=request()->session()->save();
//        session(['admin'=>null]);
//        $res=request()->session()->save();

//        echo session('admin');
        $res=request()->session()->put('admin',1234456);
            request()->session()->save();
            request()->session()->forget('admin');

        dd(request()->session()->get('admin'));



        die;
        die;
        $a_id=request()->a_id??'';
        $n_title=request()->n_title??'';
        $where=[];
        if($a_id){
            $where[]=['news.a_id','=',$a_id];
        }
        if($n_title){
            $where[]=['n_title','like','%'.$n_title.'%'];
        }
        $data=Article::all();
        $info=News::leftJoin('article',"article.a_id","=","news.a_id")->orderby('n_id','desc')->where($where)->paginate(2);

        return view('article/index',['info'=>$info,'data'=>$data,'a_id'=>$a_id,'n_title'=>$n_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $data=Brand::all();

//        $data=DB::table('article')->get();
        $data=Article::all();
//        dd($data);
//        die;
        return view('article/create',['data'=>$data]);
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
            'n_title'=>['required','unique:news','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u'],
            'a_id'=>'required',
            'is_show'=>'required',
            'is_zy'=>'required',
        ],[
            'n_title.required'=>'表题必填',
            'n_title.unique'=>'名称已存在',
            'n_title.regex'=>'必须是中文,字母，下划线，数字组成',
            'a_id.required'=>'分类必填',
            'is_show.required'=>'是否显示必填',
            'is_zy.required'=>'重要性必填',
        ]);
        if ($validator->fails())
        {
            return redirect('article/create')
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('n_img')){
            $data['n_img']=upload('n_img');
        };
        $data['n_time']=time();
        $res=News::create($data);

        if($res){
            return redirect('article/index');
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
        $datas=Article::all();
        $data=News::find($id);

//        dd($data);
        return view('article/edit',['data'=>$data,'datas'=>$datas]);
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
        if($request->hasFile('n_img')){
            $data['n_img']=upload('n_img');
        };
        $res=News::where('n_id',$id)->update($data);
        if($res!==false){
            return redirect('article/index');
        }else{
            return redirect('article/edit/',['n_id'=>$id]);
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
//        echo 111;die;
//        $n_id=request()->n_id;
//        echo $id;die;
        $res=News::destroy($id);
        if($res){
//            return redirect('article/index');
            echo json_encode(['code'=>00000,'font'=>'ok']);
        }else{
            echo json_encode(['code'=>11111,'font'=>'no']);
        }
    }
    public function uniqueness(){
        $n_title=request()->n_title;
        $n_id=request()->n_id;
        $where=[
            ['n_title','=',$n_title]
        ];
        if(!empty($n_id)){
            $where[]=['n_id','!=',$n_id];
        }

        $count=News::where($where)->count();
        $this->json($count);
    }
    public function uniquenessdo(){
        echo 123;die;
        $n_title=request()->n_title;
        $n_id=request()->n_id;
        $where=[
            ['n_title','=',$n_title]
        ];
        if(!empty($n_id)){
            $where[]=['n_id','!=',$n_id];
        }

        $count=News::where($where)->count();
        $this->json($count);
    }
    public function json($value=''){
        if($value<=0){
        echo json_encode(['code'=>00000,'font'=>'可以','count'=>$value]);
        }else{
            echo json_encode(['code'=>22222,'font'=>'已存在啦！','count'=>$value]);
        }
    }
}

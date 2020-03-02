<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\People;
use App\Http\Requests\StorePeoplePost;
use Illuminate\Validation\Rule;
class PeopleController extends Controller
{
    /**
     * 列表展示，Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username=request()->username??'';
        $where=[];
        if($username){
            $where[]=['username','like','%'.$username.'%'];
        }
//        $data=DB::table('people')->get();
//        $data=People::all();
        $pagSize=config('app.pageSize');
        $data=People::where($where)->orderby('p_id','desc')->paginate($pagSize);
       return view('people.index',['data'=>$data,'username'=>$username]);
    }

    /**
     * 添加页面，Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * 执行添加，Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
//    public function store(StorePeoplePost $request)
    {

//        $request->validate(
//            ['username'=>'required|unique:people|max:12|min:2',
//                'age' =>'required|integer:|max:3|min:1',
//            ],
//            [
//                'username.required'=>'名称必填',
//                'username.unique'=>'名称已存在',
//                'username.max'=>'名称最大是12位',
//                'username.min'=>'名称最小是2位',
//                'age.required'=>'年龄必填',
//                'age.integer'=>'年龄数据必须是数值',
//                'age.max'=>'年龄数据不合法,太大啦呦！',
//                'age.min'=>'年龄最小是1岁',
//            ]
//        );

        $data=$request->except('_token');
        $validator = Validator::make($data,[
            'username'=>'required|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,12}$/u|unique:people',
                'age' =>'required|integer|between:1,130',
            ],
            [
                'username.required'=>'名称必填',
                'username.regex'=>'名称是中文，数字，字母下划线组成2-12位',
                'username.unique'=>'名称已存在',
                'age.required'=>'年龄必填',
                'age.integer'=>'年龄数据必须是数值',
                'age.between'=>'年龄数据不合法！',
            ]);
            if ($validator->fails())
            {
                return redirect('people/create')
                    ->withErrors($validator)
                    ->withInput();
            }

        //文件上传
        if ($request->hasFile('head')) {
            $data['head']=upload('head');
        }


        $data['add_time']=time();
//       $res= DB::table('people')->insert($data);
       /*ORM操作*/
//        $people=new People();
//        $people->username=$data['username'];
//        $people->age=$data['age'];
//        $people->card=$data['card'];
//        $people->head=$data['head']??'';
//        $people->add_time=$data['add_time'];
//        $res=$people->save();
//dd($res);
        /*ORM---create*/
//        $people=new People();
        $res=People::create($data);
//        dd($res);
        if($res){
            return redirect('/people');
        }
    }

    /**
     * 预览详情，Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑页面，Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//       $user=Db::table('people')->where('p_id',$id)->first();
        /*ORM*/
       $user= People::find($id);
//        $user=People::where('p_id',$id)->first();
        return view('people.edit',['user'=>$user]);

    }

    /**
     * 执行编辑，Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except('_token');
        $validator = Validator::make($data,[
            'username'=>['required',
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{2,12}$/u',
                Rule::unique('people')->ignore($id,'p_id')],
            'age' =>'required|integer|between:1,130',
        ],
            [
                'username.required'=>'名称必填',
                'username.regex'=>'名称是中文，数字，字母下划线组成2-12位',
                'username.unique'=>'名称已存在',
                'age.required'=>'年龄必填',
                'age.integer'=>'年龄数据必须是数值',
                'age.between'=>'年龄数据不合法！',
            ]);
        if ($validator->fails())
        {
            return redirect('people/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('head')) {
            $data['head']=upload('head');
        }
//       $res= DB::table('people')->where('p_id',$id)->update($data);
//        $people=People::find($id);
//        $people->username=$data['username'];
//        $people->age=$data['age'];
//        $people->card=$data['card'];
//        if ($request->hasFile('head')) {
//            $data['head']=$this->upload('head');
//            $people->head=$data['head']??'';
//        }
//        $res=$people->save();
        $res=People::where('p_id',$id)->update($data);
//        $res=false;
        if($res!==false){
        return redirect('/people');
        }
    }

    /**
     *删除页面， Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//       $res= DB::table('people')->where('p_id',$id)->delete();
//        $res=People::where('p_id',$id)->delete();
        $res=People::destroy($id);
        if($res){
            return redirect('/people');
        }
    }
}

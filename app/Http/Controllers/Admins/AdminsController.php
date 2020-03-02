<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admins;
class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Admins::get();
        return view('admins.index', ['info' => $info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['uname']) || empty($data['upwd'])) {
            return redirect('/admins/create');
        }
        $data['upwd'] = encrypt($data['upwd']);
        if ($data['is_super'] == 2) {
            $data['is_user'] = 2;
        }
        $res = Admins::create($data);
        if ($res) {
            return redirect('/admins/index');
        } else {
            return redirect('/admins/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admins/show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Admins::find($id);
        return view('admins.edit', ['info' => $info]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $res = Admins::where(['uid' => $id])->update($data);
        if ($res !== false) {
            return redirect('/admins/index');
        } else {
            return redirect('/admins/edit/' . $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Admins::destroy($id);
        if ($res) {
            return redirect('/admins/index');
        }
    }
}

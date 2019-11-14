<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data=Node::all()->toArray();
        $data=treeLevel($data);
        return view('admin.node.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data=Node::where('pid',0)->pluck('name','id')->toArray();
//        dump($data);
//        array_unshift($data,'==顶级==');
        $data[0]="==顶级==";
//        dump($data);
        return view('admin.node.add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证
        $this->validate($request,[
           'name'=>'required'
        ]);
        //添加
        Node::create($request->except('_token'));
        return redirect(route('admin.node.index'))->with('success','添加成功');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

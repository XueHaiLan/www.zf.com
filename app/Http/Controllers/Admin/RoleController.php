<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
class RoleController extends BaseController
{
    //
    public function index()
    {
        $data=Role::paginate($this->pagesize);
        return view('admin.role.index',compact('data'));
    }

    public function create()
    {
        $nodeData=Node::all()->toArray();
        $nodeData=treeLevel($nodeData);
        return view('admin.role.add',compact('nodeData'));
    }

    public function store(Request $request)
    {
        $data=$this->validate($request,[
           'name'=>'required|unique:roles,name'
        ]);
        $model=Role::create($data);
        $model->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','添加角色成功');
    }
    public function edit(Role $role){
        $nodeData=Node::all()->toArray();
        $nodeData=treeLevel($nodeData);

        $role_node=$role->nodes()->pluck('id')->toArray();
        return view('admin.role.edit',compact('role','nodeData','role_node'));
    }

    public function update(Request $request,Role $role)
    {
//        dump($role->id);
        $data=$this->validate($request,[
           'name'=>'required|unique:roles,name,'.$role->id
        ]);
        $role->update($data);
        $role->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','修改角色成功');
    }
}

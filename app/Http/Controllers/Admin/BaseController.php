<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    protected  $pagesize=5;

    public function __construct()
    {
        $this->pagesize=env('PAGESIZE');
    }
    public function upfile(Request $request)
    {
        $node=$request->get('node');
        $file=$request->file('file');
        //1--再节点名称指定的目录下创建一个新的以此命名的目录,可以不写为空,不创建
        //2--在config中filesystems.php文件中配置的节点名称
        $url=$file->store('',$node);
        return ['status'=>0,'url'=>'/uploads/'.$node.'/'.$url];
    }
}

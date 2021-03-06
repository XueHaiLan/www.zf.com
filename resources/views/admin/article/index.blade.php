
@extends('admin.public.main')
@section('css')
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    @endsection
@section('cnt')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    @include('admin.public.msg')
    <form action="" method="get">
    <div class="text-c"> 日期范围：
        <input value="{{ request()->get('st') }}" name="st" type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input value="{{ request()->get('et') }}" name="et" type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
        <input value="{{ request()->get('kw') }}"  type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="kw" name="kw">
        <button onclick="searchBth()" type="button" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="{{ route('admin.article.create')}}"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr class="text-c">
{{--            <th width="25"><input type="checkbox" name="" value=""></th>--}}
            <th width="40">ID</th>
            <th width="150">文章标题</th>
            <th width="100">文章分类</th>
            <th width="100">更新时间</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection


@section('js')
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

    function searchBth(){
        datatable.api().ajax.reload();
        // return false;
    }
    const datatable=$('.table-bordered').dataTable({
        //页码修改
        lengthMenu:[10,20,30,50],
        //指定不排序
        columnDefs:[
            //索引下标为四的不进行排序------按钮
            {targets:[4], orderable:false}
        ],
        //初始化排序
        order:[[{{ request()->get('field') ?? 0 }},'{{ request()->get('order')?? 'desc' }}']],
        displayStart:{{ request()->get('start') ?? 0 }},
        serverSide:true,
        ajax:{
            //请求地址
            url:'{{ route("admin.article.index") }}',
            type:'GET',
            data:function (ret){
                ret.kw=$.trim($('#kw').val())
            }
        },
        columns:[
            {data:'id',className:'text-c'},
            {data:'title'},
            {data:'cate.cname',ClassName:'text-c'},
            {data:'updated_at'},
            //操作数据源中没有的数据
            {data:'actionBth',className:'text-c'}
        ],
        //生成对应行时的对应回调事件
        createdRow:function (row,data){
            //查找当前行中最后一行
            // var td=$(row).find('td:last-child')
            // var html=``
        }
    })

    /*
        参数解释：
        title	标题
        url		请求的url
        id		需要操作的数据id
        w		弹出层宽度（缺省调默认值）
        h		弹出层高度（缺省调默认值）
    */
    /*管理员-增加*/
    function admin_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-删除*/
    function admin_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*管理员-编辑*/
    function admin_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-停用*/
    function admin_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……

            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
            $(obj).remove();
            layer.msg('已停用!',{icon: 5,time:1000});
        });
    }

    /*管理员-启用*/
    function admin_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……


            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
            $(obj).remove();
            layer.msg('已启用!', {icon: 6,time:1000});
        });
    }
</script>
@endsection


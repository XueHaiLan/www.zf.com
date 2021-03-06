
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
        <input value="{{ request()->get('kw') }}"  type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="kw">
        <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="{{ route('admin.add')}}"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="40">ID</th>
            <th width="150">登录名</th>
            <th width="90">手机</th>
            <th width="150">邮箱</th>
            <th width="150">昵称</th>
            <th width="130">加入时间</th>
            <th width="90">状态</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $data as $item)
        <tr class="text-c">
            <td><input type="checkbox" value="{{ $item->id }}" name="ids[]"></td>
            <td>{{ $item['id'] }}</td>
            <td>{{ $item['username'] }}</td>
            <td>{{ $item['phone'] }}</td>
            <td>{{ $item['email'] }}</td>
            <td>{{ $item['truename'] }}</td>
            <td>{{ $item['created_at'] }}</td>
            <td>
                @if($item['deleted_at'])
                    <a p-id="{{ $item->id }}" class="label label-success radius" onclick="changeUser(1,{{ $item->id }},this)">启用</a>
                @else
                    <a p-id="{{ $item->id }}" class="label label-warning radius" onclick="changeUser(0,{{$item->id }},this)">禁用</a>
                @endif
            </td>
            <td class="td-manage">
                {!! $item->editBth('admin.edit') !!}
                {!! $item->delBth('admin.del') !!}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{$data->appends( request()->except('page'))->links()}}
@endsection


@section('js')
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    function changeUser(status,id,obg){
        console.log(id)
        var idss=$(obg).attr('p-id');
        if(status==0){
            $.ajax({
                url:"{{ route('admin.dell') }}",
                type:"delete",
                data:{
                    _token:"{{ csrf_token() }}",
                    ids:[id]
                }
            }).then(res=>{
                $(obg).removeClass('label-warning').addClass('label-success').html('启用');
                $(obg).removeAttr('onclick').attr('onclick',"changeUser(1,"+idss+",this)");
            })
        }else{
            $.ajax({
                url:"{{ route('admin.restore') }}",
                data:{id}
            }).then(res=>{
                // console.log(res)
                $(obg).removeClass('label-success').addClass('label-warning').html('禁用');
                $(obg).removeAttr('onclick').attr('onclick',"changeUser(0,"+idss+",this)");
            })
        }
    }
    function datadel(){
        var inputs=$('input[name="ids[]"]:checked');
        // console.log(inputs);
        var ids=[];
        inputs.map((key,item)=>{
            ids.push($(item).val())
        })
        // console.log(ids)
        $.ajax({
            url:"{{ route('admin.dell') }}",
            type:'delete',
            data:{_token:"{{ csrf_token() }}",ids}
        }).then(res=>{
            // console.log(res);
            if(!res.status){
                inputs.map((key,item)=>{
                    $(item).parents('tr').remove();
                })
                layer.msg(res.msg,{icon:1,time:1000})
            }else{
                layer.msg(res.msg,{icon:5,time:1000})
            }
        })
    }
    $('#del').click(function (){
        var url=$(this).attr('href')
        // console.log(url)
        layer.confirm('您确定要删除这个用户么?',{
            bth:['确定','取消']
        },()=>{
            $.ajax({
                url,
                type:'delete',
                data:{_token:"{{ csrf_token() }}"}
            }).then(res=>{
                // console.log(res.msg);
                if(!res.status){
                    $(this).parents('tr').remove();
                    layer.msg(res.msg,{icon:1,time:1000})
                }else{
                    layer.msg(res.msg,{icon:5,time:1000})
                }
            })
        })
        return false
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


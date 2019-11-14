@extends('admin.public.main')
@section('cnt')
<article class="page-container">
    @include('admin.public.msg')
    <form action="{{ route('admin.node.store') }}" method="post" class="form form-horizontal" id="form-admin-add">
        @csrf
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上级菜单：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="pid" class="select"><span class="sekect-box">
                    @foreach($data as $id=>$name)
                        <option @if($id==0) selected @endif value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" id="adminName" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>路由别名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('route_name') }}" placeholder="" id="adminName" name="route_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否菜单：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="is_menu" type="radio" id="sex-1" checked value="1">
                    <label for="sex-1">是</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="sex-2" name="is_menu" value="0">
                    <label for="sex-2">否</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
@endsection

@section('js')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-admin-add").validate({
            rules:{
                name:{
                    required:true
                }
            },
            message:{
                name:{
                    required:'名字不能为空'
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                form.submit();
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection

@extends('admin.public.main')
@section('css')
    <link rel="stylesheet" href="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.css">
@endsection
@section('cnt')
<article class="page-container">
    @include('admin.public.msg')
    <form action="{{ route('admin.fangattr.store') }}" method="post" class="form form-horizontal" id="form-admin-add">
        @csrf
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>顶级属性：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select id="pid" name="pid" class="select">
                    @foreach($data as $key=>$item)
                        <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
				</select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>属性名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>字段名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('field_name') }}" placeholder="" id="field_name" name="field_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图标：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="filePicker">选择图片</div>
                    <input type="hidden" name="icon" id="pic">
                    <img src="" style="width: 100px;" id="showpic">
                </div>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</article>
@endsection

@section('js')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript">
    $(function(){
        // 字段验证
        // 自定义验证器
        jQuery.validator.addMethod('fieldName',function (value,element) {
            var bool=$('#pid').val()==0 ? false : true;
            //正则
            var reg=/[a-zA-Z_]+/;
            return bool || (reg.test(value));
        },'选择顶级字段一定要填写对应的字段名称');
        $('#form-admin-add').validate({
            rules:{
                name:{
                    required:true
                },
                field_name:{
                    fieldName:true
                }
            },
            onkeyup:false,
            success:"valid",
            submitHandler:function (form) {
                form.submit();
            }
        })
        //异步文件上传
        var uploader = WebUploader.create({
            auto: true,// 选完文件后，是否自动上传。
            swf: '{{ staticAdminWeb() }}lib/webuploader-0.1.5/Uploader.swf',// swf文件路径
            server: '{{ route('admin.base.upfile') }}',// 文件接收服务端。
            pick: {
                id:'#filePicker',
                multiple:false,
            },// 内部根据当前运行是创建，可能是input元素，也可能是flash. 这里是div的id
            resize:false, //不压缩img如果是jpeg,文件上传前会压缩一把再上传
            formData:{_token:"{{ csrf_token() }}",node:'fangAttr'},//表单额外值
            fileVal:'file'//上传表单额外名称
        });
        uploader.on('uploadSuccess',function(file,{url} ){
            // console.log()
            $('#pic').val(url);
            $('#showpic').attr('src',url);
        })

    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection

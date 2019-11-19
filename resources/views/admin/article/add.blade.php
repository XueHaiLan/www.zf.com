@extends('admin.public.main')
@section('css')
    <link rel="stylesheet" href="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.css">
@endsection
@section('cnt')
<article class="page-container">
    @include('admin.public.msg')
    <form action="{{ route('admin.article.store') }}" method="post" class="form form-horizontal" id="form-admin-add">
        @csrf
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="title" name="title">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="cid" class="select">
                    @foreach($cateData as $item)
					<option value="{{ $item['id'] }}">{{ $item['cname'] }}</option>
                    @endforeach
				</select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="desn" id="desn" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">封面图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="filePicker">选择图片</div>
                    <input type="hidden" name="pic" id="pic">
                    <img src="" style="width: 100px;" id="showpic">
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">文章内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea id="body" name="body"></textarea>
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
        $('#form-admin-add').validate({
            rules:{
                title:{
                    required:true
                },
                desn:{
                    required:true
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
            pick: '#filePicker',// 内部根据当前运行是创建，可能是input元素，也可能是flash. 这里是div的id
            resize:false, //不压缩img如果是jpeg,文件上传前会压缩一把再上传
            formData:{_token:"{{ csrf_token() }}",node:'articles'},//表单额外值
            fileVal:'file'//上传表单额外名称
        });
        uploader.on('uploadSuccess',function(file,{url} ){
            // console.log()
          $('#pic').val(url);
          $('#showpic').attr('src',url);
        })
        //富文本
        var ue=UE.getEditor('body',{
            initiaIFrameHeight: 500
        })
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection

@extends('admin.public.main')
@section('css')
    <link rel="stylesheet" href="{{ staticAdminWeb() }}lib/webuploader/0.1.5/webuploader.css">
@endsection
@section('cnt')
<article class="page-container">
    @include('admin.public.msg')
    <form action="{{ route('admin.fangowner.store') }}" method="post" class="form form-horizontal" id="form-admin-add">
        @csrf
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房东姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>性别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="sex" type="radio" id="sex-1" checked value="男">
                    <label for="sex-1">男</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="sex-2" name="sex" value="女">
                    <label for="sex-2">女</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房东年龄：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('age') }}" placeholder="" id="age" name="age">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>手机号码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('phone') }}" placeholder="" id="phone" name="phone">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>身份证号码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('card') }}" placeholder="" id="card" name="card">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('address') }}" placeholder="" id="address" name="address">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系邮箱：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('email') }}" placeholder="" id="email" name="email">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图标：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="filePicker">选择图片</div>
                    <input type="hidden" name="pic" id="pic">
{{--                    //上传图片显示--}}
                    <div id="imgbox"></div>
                </div>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
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
        // 自定义验证器----手机号
        jQuery.validator.addMethod('checkPhone',function (value,element) {
            //正则
            var reg=/^1[3-9]\d{9}$/;
            return this.optional(element) || (reg.test(value));
        },'你输入的不是一个合法的国内号码');
        jQuery.validator.addMethod('checkCard',function(value,element){
            var card= value.replace(' ','');
            var len=card.length;
            var bool=len ==18 ? true : false;
            return this.optional(element) || bool;
        })
        $('#form-admin-add').validate({
            rules:{
                name:{
                    required:true
                },
                age:{
                    required:true,
                    digits:true,
                    min:1,
                    max:110
                },
                phone:{
                    required:true,
                    checkPhone:true
                },
                card:{
                    required:true,
                    checkCard:true
                },
                address:{
                    required:true
                },
                email:{
                    required:true,
                    email:true
                }
            },
            //回车取消
            onkeyup:false,
            success:"valid",
            //验证通过后回调函数
            submitHandler:function (form){
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
            },// 内部根据当前运行是创建，可能是input元素，也可能是flash. 这里是div的id
            resize:false, //不压缩img如果是jpeg,文件上传前会压缩一把再上传
            formData:{_token:"{{ csrf_token() }}",node:'fangowner'},//表单额外值
            fileVal:'file'//上传表单额外名称
        });
        uploader.on('uploadSuccess',function(file,{url} ){
            // console.log()
            let val=$('#pic').val();
            $('#pic').val(val+'#'+url);
            var imgObj=$('<img style="height: 50px; width: 50px" />');
            imgObj.attr('src',url);
            $('#imgbox').append(imgObj);
        })

    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection

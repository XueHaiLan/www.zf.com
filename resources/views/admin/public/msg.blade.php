{{-- 表单验证错误信息 --}}
@if($errors->any())
    <div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif

{{-- 表单验证,成功信息 --}}

@if(session()->has('success'))
    <div class="Huialert Huialert-success"><i class="Hui-iconfont">&#xe6a6;</i>
            <li>{{ session('success') }}</li>
    </div>
@endif

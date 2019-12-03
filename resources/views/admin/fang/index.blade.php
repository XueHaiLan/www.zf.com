@extends('admin.public.main')

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 房源列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input value="{{ request()->get('st') }}" type="text" onfocus="WdatePicker({})" name="st" class="input-text Wdate" style="width:120px;">
            -
            <input value="{{ request()->get('et') }}" type="text" onfocus="WdatePicker({})" name="et" class="input-text Wdate" style="width:120px;">
            <input value="{{ request()->get('kw') }}" type="text" class="input-text" style="width:250px" placeholder="输入搜索的账号" id="kw">
            <button type="button" class="btn btn-success radius" onclick="searchBtn()">
                <i class="Hui-iconfont">&#xe665;</i> 搜索一下
            </button>
        </div>

        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
                <a href="{{ route('admin.fang.create') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加房源
                </a>
            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="20">ID</th>
                    <th width="100">房源名称</th>
                    <th width="100">小区地址</th>
                    <th width="80">租赁方式</th>
                    <th width="80">房源业主</th>
                    <th width="80">房源租金</th>
                    <th width="80">是否推荐</th>
                    <th width="80">房源状态</th>
                    <th width="120">配套设施</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ $item['fang_name'] }}</td>
                        <td>{{ $item['fang_addr'] }}</td>
                        <td>{{ $item->getAttrIdByName($item['fang_rent_class']) }}</td>
                        <td>{{ $item['fangowner']->name }}</td>
                        <td>{{ $item['fang_rent'] }}</td>
                        <td>{{ $item['is_recommend'] == '0' ? '否' :'是' }}</td>
                        <td>{{ $item['fang_status'] == 0 ? '待租' : '已租' }}</td>
                        <td>{{ $item->getAttrIdByName(explode(',',$item->fang_config)) }}</td>
                        <td>
                            {!! $item->editBth('admin.fang.edit') !!}
                            {!! $item->delBth('admin.fang.destroy') !!}

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{-- 分页 --}}
        {{ $data->appends(request()->except(['page']))->links() }}
    </div>
@endsection

@section('js')
@endsection


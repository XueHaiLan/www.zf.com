<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空数据
        Admin::truncate();
        //调用factory数据工厂,生成数据
        factory(Admin::class,10)->create();
        //插入登陆的账号
        Admin::where('id','1')->update(['username'=>'admin']);
    }
}

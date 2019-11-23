<?php

namespace App\Observers;

use App\Models\Fang;
use GuzzleHttp\Client;

class FangObserver
{
    /**
     * Handle the fang "created" event.
     *
     * @param  \App\Models\Fang  $fang
     * @return void
     */
    public function creating(Fang $fang)
    {
//        dd(123);
        //放松请求---用高得开放平台将地址转换为经纬度
        $url=config('gd.url');
//        dump($url);exit();
        $client=new Client(['timeout'=>5,'verify'=>false]);
        $response=$client->get($url.request()->get('fang_addr'));
        $response=(string)$response->getBody();
        $response=json_decode($response,true)['geocodes'];
        $longitude=$latitude=0;
        if(count($response)>0){
            //获取经纬度
            $location=$response[0]['location'];
            $location=explode(',',$location);
            [$longitude,$latitude]=$location;
        }
        //赋值经纬度
        $fang->latitude=$latitude;
        $fang->longitude=$longitude;
        //处理配套设施转化为字符串用，隔开
        $fang->fang_config=implode(',',request()->get('fang_config'));
    }

    /**
     * Handle the fang "updated" event.
     *
     * @param  \App\Models\Fang  $fang
     * @return void
     */
    public function updated(Fang $fang)
    {
        //
    }

    /**
     * Handle the fang "deleted" event.
     *
     * @param  \App\Models\Fang  $fang
     * @return void
     */
    public function deleted(Fang $fang)
    {
        //
    }

    /**
     * Handle the fang "restored" event.
     *
     * @param  \App\Models\Fang  $fang
     * @return void
     */
    public function restored(Fang $fang)
    {
        //
    }

    /**
     * Handle the fang "force deleted" event.
     *
     * @param  \App\Models\Fang  $fang
     * @return void
     */
    public function forceDeleted(Fang $fang)
    {
        //
    }
}

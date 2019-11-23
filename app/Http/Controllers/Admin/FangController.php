<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use App\Models\Fangattr;
use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use GuzzleHttp\Client;

class FangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '列表';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $url=config('gd.url');
////        dump($url);exit();
//        $client=new Client(['timeout'=>5,'verify'=>false]);
//        $response=$client->get($url.'唐山市丰南区小集镇');
//        $response=(string)$response->getBody();
//        $response=json_decode($response,true);
//        dump($response['geocodes'][0]['location']);exit();
        $pData=$this->getCity();
//        dump($pData);exit();
      $attrData=Fangattr::all()->toArray();
      $attrData=subTree2($attrData);
      $fData=FangOwner::all();
//      dump($fData);exit();
        return view('admin.fang.add',compact('pData','attrData','fData'));
    }

    public function getCity()
    {

        $pid=\request()->get('pid',0);
        return City::where('pid',$pid)->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['_token','file']);
        Fang::create($data);
        return redirect(route('admin.fang.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function show(Fang $fang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function edit(Fang $fang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang)
    {
        //
    }
}

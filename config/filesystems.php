<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        //文章图片上传配置
        'articles'=>[
            //驱动 本地文件
            'driver'=>'local',
            //上传到服务器的位置
            'root'=>public_path('uploads/articles'),
        ],
        //导出excel
        'fangowenrexcel'=>[
            'driver'=>'local',
            'root'=>public_path('uploads/fangownerexcel'),
        ],
        //房源信息图片上传配置
        'fangAttr'=>[
            'driver'=>'local',
            'root'=>public_path('uploads/fangAttr'),
        ],
        'fangowner'=>[
            'driver'=>'local',
            'root'=>public_path('uploads/fangowner'),
        ],
        'fang'=>[
            'driver'=>'local',
            'root'=>public_path('uploads/fang'),
        ],
        //小程序图片上传
        'renting'=>[
            'driver'=>'local',
            'root'=>public_path('uploads/renting'),
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],

];

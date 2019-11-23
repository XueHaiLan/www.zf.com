<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;


class FangOwnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//    #成员属性
    public $userData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->userData=$data;
    }

    /**
     * Execute the job.
     *工作任务
     * @return void
     */
    public function handle()
    {
        $email=$this->userData['email'];
        $name=$this->userData['name'];

        Mail::raw('添加你的信息成功，稍后会有工作人员联系您',function (Message $message)use($email,$name){
            $message->subject('信息添加成功通知邮件');
            $message->to($email,$name);
        });
    }
}

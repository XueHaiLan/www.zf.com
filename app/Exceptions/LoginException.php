<?php

namespace App\Exceptions;

use Exception;

class LoginException extends Exception
{
    public $status=[
        1=>'登录失败',
        2=>'登录成功',
        3=>'',
        4=>'没有此信息'
    ];
}

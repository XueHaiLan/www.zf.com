<?php

namespace App\Exceptions;

use Exception;

class MyvalidateException extends Exception
{
    private $status=[
        3=>'验证不通过'
    ];
}

<?php

namespace App\Exceptions;

class HomeNotFoundException extends BaseException
{
    protected $message = 'Home not found!';
    protected $code = 404;
}

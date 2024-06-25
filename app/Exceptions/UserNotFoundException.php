<?php

namespace App\Exceptions;

class UserNotFoundException extends BaseException
{
    protected $message = 'User not found!';
    protected $code = 400;
}

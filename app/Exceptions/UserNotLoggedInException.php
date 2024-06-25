<?php

namespace App\Exceptions;

class UserNotLoggedInException extends BaseException
{
    protected $message = 'User not logged in!';
    protected $code = 400;
}

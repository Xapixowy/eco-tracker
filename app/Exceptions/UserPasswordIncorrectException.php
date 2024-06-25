<?php

namespace App\Exceptions;

class UserPasswordIncorrectException extends BaseException
{
    protected $message = 'User password incorrect!';
    protected $code = 400;
}

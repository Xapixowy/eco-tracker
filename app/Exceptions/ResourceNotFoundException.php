<?php

namespace App\Exceptions;

class ResourceNotFoundException extends BaseException
{
    protected $message = 'Resource not found!';
    protected $code = 404;
}

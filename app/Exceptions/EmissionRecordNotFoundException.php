<?php

namespace App\Exceptions;

class EmissionRecordNotFoundException extends BaseException
{
    protected $message = 'Emission record not found!';
    protected $code = 404;
}

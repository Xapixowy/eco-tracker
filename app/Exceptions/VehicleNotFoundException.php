<?php

namespace App\Exceptions;

class VehicleNotFoundException extends BaseException
{
    protected $message = 'Vehicle not found!';
    protected $code = 400;
}

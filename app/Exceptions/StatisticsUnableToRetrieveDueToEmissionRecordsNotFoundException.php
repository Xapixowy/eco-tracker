<?php

namespace App\Exceptions;

class StatisticsUnableToRetrieveDueToEmissionRecordsNotFoundException extends BaseException
{
    protected $message = 'Unable to retrieve statistics due to emission records not found!';
    protected $code = 404;
}

<?php

namespace App\Enums;

enum FuelTypeEnum: string
{
    case DIESEL = 'Diesel';
    case GASOLINE = 'Gasoline';
    case ELECTRICITY = 'Electricity';
    case NATURAL_GAS = 'Natural Gas';
}

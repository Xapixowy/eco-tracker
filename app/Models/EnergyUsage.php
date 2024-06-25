<?php

namespace App\Models;

class EnergyUsage extends MediaUsage
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'electricity_consumption'
        ]);
    }
}

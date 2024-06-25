<?php

namespace App\Models;

class GasUsage extends MediaUsage
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'gas_consumption'
        ]);
    }
}

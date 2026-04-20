<?php

namespace App\Modules\Reporting\DTOs;

class CycleTimeDTO
{
    public function __construct(
        public ?float $average_days
    ) {}
}

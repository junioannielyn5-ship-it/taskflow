<?php

namespace App\Modules\Reporting\DTOs;

class CompletionStatsDTO
{
    public function __construct(
        public int $completed,
        public int $pending
    ) {}
}

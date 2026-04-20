<?php

namespace App\Modules\Reporting\DTOs;

class OverdueTaskDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $due_date,
        public string $status
    ) {}
}

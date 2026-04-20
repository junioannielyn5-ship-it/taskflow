<?php

namespace App\Modules\Shared\Enums;

enum ProjectStatus: string
{
    case PENDING_REQUEST = 'pending_request';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
}

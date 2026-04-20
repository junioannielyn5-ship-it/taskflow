<?php

namespace App\Modules\Shared\Exceptions;

use Exception;

class ModuleAccessDeniedException extends Exception
{
    public function __construct($message = 'Access denied to this module.', $code = 403)
    {
        parent::__construct($message, $code);
    }
}

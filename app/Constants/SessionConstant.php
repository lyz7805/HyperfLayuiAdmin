<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class SessionConstant extends AbstractConstants
{
    const ADMIN_USER_SESSION_KEY = 'admin_user';
}

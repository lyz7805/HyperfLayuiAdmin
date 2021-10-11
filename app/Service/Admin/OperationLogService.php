<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Model\AdminOperationLog;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\AbstractAdminService;

class OperationLogService extends AbstractAdminService
{
    /**
     * @Inject
     * @var AdminOperationLog
     */
    protected $model;
}

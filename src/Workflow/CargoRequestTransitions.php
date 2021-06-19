<?php

namespace App\Workflow;

final class CargoRequestTransitions
{
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_LOCK_CARGO_REQUEST = 'lock cargo request';
    const STATUS_DECLINED_OWNER = 'decline owner';
    const STATUS_DECLINED_EXECUTOR = 'decline executor';
    const STATUS_EXECUTED = 'executed';
    const STATUS_EXECUTED_CONFIRMATION = 'executed confirmation';
    const STATUS_REJECTED_EXECUTION = 'rejected execution';

    const STATUS_CHOICE = [
        self::STATUS_SUBMITTED,
        self::STATUS_APPROVED,
        self::STATUS_LOCK_CARGO_REQUEST,
        self::STATUS_DECLINED_OWNER,
        self::STATUS_DECLINED_EXECUTOR,
        self::STATUS_EXECUTED,
        self::STATUS_EXECUTED_CONFIRMATION,
        self::STATUS_REJECTED_EXECUTION
    ];
}

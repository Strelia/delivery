<?php

namespace App\Workflow;

final class CargoRequestTransitions
{
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_LOCK_CARGO_REQUEST = 'lock cargo request';
    const STATUS_DECLINED_OWNER = 'decline owner';
    const STATUS_EXECUTED = 'executed';
    const STATUS_REJECTED_EXECUTION = 'rejected execution';
    const STATUS_CONFIRMED_FULFILLMENT = 'confirmed execution';

    const STATUS_CHOICE = [
        self::STATUS_SUBMITTED,
        self::STATUS_APPROVED,
        self::STATUS_LOCK_CARGO_REQUEST,
        self::STATUS_DECLINED_OWNER,
        self::STATUS_EXECUTED,
        self::STATUS_REJECTED_EXECUTION,
        self::STATUS_CONFIRMED_FULFILLMENT
    ];

    const IS_EXECUTOR = 'subject.getExecutor() === user.getCompany()';
    const IS_OWNER = 'subject.getCargo().getOwner() === user.getCompany()';
}
